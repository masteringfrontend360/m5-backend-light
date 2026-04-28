<?php

namespace App\Models;

class Producto {

    private int $id;
    private string $nombre;
    private float $precio;
    private int $stock;

    public function __construct($id, $nombre, $precio, $stock) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getPrecio() { return $this->precio; }
    public function getStock() { return $this->stock; }
}