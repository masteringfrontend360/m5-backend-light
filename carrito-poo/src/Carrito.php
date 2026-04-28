<?php

namespace CarritoPOO;

/**
 * Clase Carrito
 * Representa el carrito de compra y gestiona los productos añadidos
 */
class Carrito
{
    /**
     * Array asociativo: [id_producto => cantidad]
     * Almacena qué cantidad de cada producto hay en el carrito
     */
    private array $items = [];

    /**
     * Referencia a los productos disponibles (para validar stock)
     */
    private array $catalogo = [];

    /**
     * Constructor: inicializa el carrito con el catálogo de productos disponibles
     */
    public function __construct(array $catalogo = [])
    {
        $this->catalogo = $catalogo;
    }

    /**
     * Establece el catálogo de productos disponibles
     */
    public function setCatalogo(array $catalogo): void
    {
        $this->catalogo = $catalogo;
    }

    /**
     * Obtiene el catálogo actual
     */
    public function getCatalogo(): array
    {
        return $this->catalogo;
    }

    /**
     * Añade un producto al carrito
     * Valida que:
     * - La cantidad sea válida (> 0)
     * - El producto exista en el catálogo
     * - Haya stock suficiente
     *
     * @param int $productoId
     * @param int $cantidad
     * @return array ['exito' => bool, 'mensaje' => string]
     */
    public function anadir(int $productoId, int $cantidad): array
    {
        // Validar cantidad
        if ($cantidad <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'La cantidad debe ser mayor que 0'
            ];
        }

        // Buscar el producto en el catálogo
        $producto = $this->buscarProductoEnCatalogo($productoId);

        if ($producto === null) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado en el catálogo'
            ];
        }

        // Validar stock disponible
        if (!$producto->tieneStockSuficiente($cantidad)) {
            return [
                'exito' => false,
                'mensaje' => 'Stock insuficiente. Disponible: ' . $producto->getStock() . ' unidades'
            ];
        }

        // Si ya existe en el carrito, sumar cantidad
        if (isset($this->items[$productoId])) {
            $nuevaCantidad = $this->items[$productoId] + $cantidad;

            // Validar que la nueva cantidad no supere el stock
            if ($nuevaCantidad > $producto->getStock()) {
                return [
                    'exito' => false,
                    'mensaje' => 'No puedes añadir más. Stock máximo: ' . $producto->getStock() . ' unidades'
                ];
            }

            $this->items[$productoId] = $nuevaCantidad;
        } else {
            // Añadir nuevo producto
            $this->items[$productoId] = $cantidad;
        }

        return [
            'exito' => true,
            'mensaje' => 'Producto añadido: ' . $cantidad . ' unidades de ' . $producto->getNombre()
        ];
    }

    /**
     * Elimina completamente un producto del carrito
     *
     * @param int $productoId
     * @return bool
     */
    public function eliminar(int $productoId): bool
    {
        if (isset($this->items[$productoId])) {
            unset($this->items[$productoId]);
            return true;
        }
        return false;
    }

    /**
     * Reduce la cantidad de un producto (o lo elimina si llega a 0)
     *
     * @param int $productoId
     * @param int $cantidad
     * @return array ['exito' => bool, 'mensaje' => string]
     */
    public function reducirCantidad(int $productoId, int $cantidad): array
    {
        if (!isset($this->items[$productoId])) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no está en el carrito'
            ];
        }

        if ($cantidad <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'La cantidad a reducir debe ser mayor que 0'
            ];
        }

        $cantidadActual = $this->items[$productoId];
        $nuevaCantidad = $cantidadActual - $cantidad;

        if ($nuevaCantidad <= 0) {
            unset($this->items[$productoId]);
            $mensaje = 'Producto eliminado del carrito';
        } else {
            $this->items[$productoId] = $nuevaCantidad;
            $mensaje = 'Cantidad reducida a ' . $nuevaCantidad . ' unidades';
        }

        return [
            'exito' => true,
            'mensaje' => $mensaje
        ];
    }

    /**
     * Vacía completamente el carrito
     */
    public function vaciar(): void
    {
        $this->items = [];
    }

    /**
     * Obtiene la cantidad de unidades totales en el carrito
     */
    public function getNumeroUnidades(): int
    {
        return array_sum($this->items);
    }

    /**
     * Obtiene el número de líneas (productos distintos) en el carrito
     */
    public function getNumeroLineas(): int
    {
        return count($this->items);
    }

    /**
     * Calcula el total del carrito
     * Retorna null si no hay catálogo definido
     */
    public function calcularTotal(): ?float
    {
        if (empty($this->catalogo)) {
            return null;
        }

        $total = 0;

        foreach ($this->items as $productoId => $cantidad) {
            $producto = $this->buscarProductoEnCatalogo($productoId);
            if ($producto !== null) {
                $total += $producto->getPrecio() * $cantidad;
            }
        }

        return $total;
    }

    /**
     * Obtiene el total formateado
     */
    public function getTotalFormateado(): string
    {
        $total = $this->calcularTotal();
        if ($total === null) {
            return 'No disponible';
        }
        return number_format($total, 2, ',', '.') . ' €';
    }

    /**
     * Obtiene los items del carrito con información detallada del producto
     */
    public function getItems(): array
    {
        $itemsDetallados = [];

        foreach ($this->items as $productoId => $cantidad) {
            $producto = $this->buscarProductoEnCatalogo($productoId);
            if ($producto !== null) {
                $itemsDetallados[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => $producto->getPrecio() * $cantidad
                ];
            }
        }

        return $itemsDetallados;
    }

    /**
     * Obtiene el array interno de items (id => cantidad)
     */
    public function getItemsRaw(): array
    {
        return $this->items;
    }

    /**
     * Establece los items directamente (para recuperar de sesión)
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Comprueba si el carrito está vacío
     */
    public function estaVacio(): bool
    {
        return empty($this->items);
    }

    /**
     * Busca un producto en el catálogo por su ID
     */
    private function buscarProductoEnCatalogo(int $productoId): ?Producto
    {
        foreach ($this->catalogo as $producto) {
            if ($producto->getId() === $productoId) {
                return $producto;
            }
        }
        return null;
    }

    /**
     * Calcula el IVA (mejora opcional)
     * Asume 21% de IVA
     */
    public function calcularIVA(float $porcentaje = 21): ?float
    {
        $total = $this->calcularTotal();
        if ($total === null) {
            return null;
        }
        return $total * ($porcentaje / 100);
    }

    /**
     * Calcula el total con IVA incluido
     */
    public function calcularTotalConIVA(float $porcentajeIVA = 21): ?float
    {
        $total = $this->calcularTotal();
        if ($total === null) {
            return null;
        }
        return $total + $this->calcularIVA($porcentajeIVA);
    }

    /**
     * Obtiene un resumen del carrito como string
     */
    public function getResumen(): string
    {
        if ($this->estaVacio()) {
            return 'Carrito vacío';
        }

        $lineas = [];
        foreach ($this->getItems() as $item) {
            $lineas[] = "{$item['cantidad']}x {$item['producto']->getNombre()} = " .
                       number_format($item['subtotal'], 2, ',', '.') . ' €';
        }

        return implode("\n", $lineas) . "\n\nTotal: " . $this->getTotalFormateado();
    }
}
