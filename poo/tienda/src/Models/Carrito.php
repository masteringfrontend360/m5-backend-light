<?php

namespace App\Models;

class Carrito
{
    /**
     * Estructura interna: ['id_producto' => ['producto' => Producto, 'cantidad' => int]]
     */
    private array $items = [];

    // ──────────────────────────────────────────
    //  Gestión de items
    // ──────────────────────────────────────────

    /**
     * Añade un producto al carrito validando cantidad y stock.
     * Devuelve un array ['ok' => bool, 'mensaje' => string].
     */
    public function agregarProducto(Producto $producto, int $cantidad): array
    {
        if ($cantidad <= 0) {
            return ['ok' => false, 'mensaje' => 'La cantidad debe ser mayor que cero.'];
        }

        $yaEnCarrito = $this->getCantidad($producto->id);
        $totalDeseado = $yaEnCarrito + $cantidad;

        if (!$producto->tieneSuficienteStock($totalDeseado)) {
            $disponible = $producto->stock - $yaEnCarrito;
            if ($disponible <= 0) {
                return ['ok' => false, 'mensaje' => "No quedan más unidades disponibles de \"{$producto->nombre}\"."];
            }
            return [
                'ok'      => false,
                'mensaje' => "Solo puedes añadir {$disponible} unidad(es) más de \"{$producto->nombre}\".",
            ];
        }

        if (isset($this->items[$producto->id])) {
            $this->items[$producto->id]['cantidad'] += $cantidad;
        } else {
            $this->items[$producto->id] = [
                'producto' => $producto,
                'cantidad' => $cantidad,
            ];
        }

        return ['ok' => true, 'mensaje' => "\"{$producto->nombre}\" añadido al carrito."];
    }

    /**
     * Elimina completamente un producto del carrito.
     */
    public function eliminarProducto(int $idProducto): void
    {
        unset($this->items[$idProducto]);
    }

    /**
     * Reduce la cantidad de un producto. Si llega a 0 o menos, lo elimina.
     */
    public function reducirCantidad(int $idProducto, int $cantidad = 1): void
    {
        if (!isset($this->items[$idProducto])) {
            return;
        }

        $this->items[$idProducto]['cantidad'] -= $cantidad;

        if ($this->items[$idProducto]['cantidad'] <= 0) {
            $this->eliminarProducto($idProducto);
        }
    }

    /**
     * Vacía el carrito por completo.
     */
    public function vaciar(): void
    {
        $this->items = [];
    }

    // ──────────────────────────────────────────
    //  Consultas
    // ──────────────────────────────────────────

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCantidad(int $idProducto): int
    {
        return $this->items[$idProducto]['cantidad'] ?? 0;
    }

    public function getTotalUnidades(): int
    {
        return array_sum(array_column($this->items, 'cantidad'));
    }

    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item['producto']->getPrecio() * $item['cantidad'];
        }
        return $total;
    }

    public function getTotalFormateado(): string
    {
        return number_format($this->getTotal(), 2, ',', '.') . ' €';
    }

    public function estaVacio(): bool
    {
        return empty($this->items);
    }

    // ──────────────────────────────────────────
    //  Persistencia en sesión
    // ──────────────────────────────────────────

    /**
     * Guarda el carrito en $_SESSION.
     */
    public function guardarEnSesion(): void
    {
        $_SESSION['carrito'] = $this->items;
    }

    /**
     * Carga el carrito desde $_SESSION (factory estático).
     */
    public static function cargarDesdeSesion(): self
    {
        $carrito = new self();
        if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
            $carrito->items = $_SESSION['carrito'];
        }
        return $carrito;
    }
}
