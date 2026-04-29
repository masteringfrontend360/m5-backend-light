<?php
namespace App\Models;

class Carrito {
    private array $items = []; // Array de arrays con 'producto' (objeto) y 'cantidad'

    public function añadir(Producto $producto, int $cantidad) {
        if ($cantidad <= 0) throw new \Exception("Cantidad no válida.");
        if (!$producto->hayStock($cantidad)) throw new \Exception("No hay stock suficiente.");

        $id = $producto->getId();
        if (isset($this->items[$id])) {
            $nuevaCantidad = $this->items[$id]['cantidad'] + $cantidad;
            if (!$producto->hayStock($nuevaCantidad)) throw new \Exception("Superas el stock disponible.");
            $this->items[$id]['cantidad'] = $nuevaCantidad;
        } else {
            $this->items[$id] = [
                'producto' => $producto,
                'cantidad' => $cantidad
            ];
        }
    }

    public function eliminar(int $id) {
        unset($this->items[$id]);
    }

    public function vaciar() {
        $this->items = [];
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getTotal(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['producto']->getPrecio() * $item['cantidad'];
        }
        return $total;
    }

    public function getTotalUnidades(): int {
        return array_sum(array_column($this->items, 'cantidad'));
    }
}