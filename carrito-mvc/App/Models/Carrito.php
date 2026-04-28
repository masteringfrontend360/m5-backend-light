<?php

namespace App\Models;

class Carrito {

    private array $items = [];
    private array $catalogo;

    public function __construct($catalogo) {
        $this->catalogo = $catalogo;
    }

    public function anadir($id, $cantidad) {

        if ($cantidad <= 0) {
            return ['exito' => false, 'mensaje' => 'Cantidad inválida'];
        }

        foreach ($this->catalogo as $producto) {

            if ($producto->getId() === $id) {

                if ($cantidad > $producto->getStock()) {
                    return ['exito' => false, 'mensaje' => 'Sin stock suficiente'];
                }

                $this->items[$id]['producto'] = $producto;
                $this->items[$id]['cantidad'] =
                    ($this->items[$id]['cantidad'] ?? 0) + $cantidad;

                return ['exito' => true, 'mensaje' => 'Producto añadido'];
            }
        }

        return ['exito' => false, 'mensaje' => 'Producto no encontrado'];
    }

    public function eliminar($id) {
        unset($this->items[$id]);
        return true;
    }

    public function vaciar() {
        $this->items = [];
    }

    public function getItems() {
        return $this->items;
    }

    public function estaVacio() {
        return empty($this->items);
    }

    public function getNumeroUnidades() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['cantidad'];
        }
        return $total;
    }

    public function calcularTotal() {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item['producto']->getPrecio() * $item['cantidad'];
        }

        return $total;
    }
}