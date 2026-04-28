<?php

namespace App\Models;

class Producto
{
    public int $id;
    public string $nombre;
    private float $precio;
    public int $stock;
    public string $descripcion;
    public string $categoria;
    public string $imagen;

    public function __construct(
        int $id,
        string $nombre,
        float $precio,
        int $stock,
        string $descripcion = '',
        string $categoria = 'General',
        string $imagen = ''
    ) {
        $this->id          = $id;
        $this->nombre      = $nombre;
        $this->precio      = $precio;
        $this->stock       = $stock;
        $this->descripcion = $descripcion;
        $this->categoria   = $categoria;
        $this->imagen      = $imagen;
    }

    /**
     * Comprueba si hay suficiente stock para la cantidad pedida.
     */
    public function tieneSuficienteStock(int $cantidad): bool
    {
        return $this->stock >= $cantidad;
    }

    /**
     * Devuelve el precio formateado con símbolo de euro.
     */
    public function getPrecioFormateado(): string
    {
        return number_format($this->precio, 2, ',', '.') . ' €';
    }

    /**
     * Devuelve el precio como float (necesario para cálculos).
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Resumen corto del producto para el carrito u otras vistas.
     */
    public function getResumen(): string
    {
        return "{$this->nombre} — {$this->getPrecioFormateado()}";
    }
}
