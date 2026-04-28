<?php

namespace CarritoPOO;

/**
 * Clase Producto
 * Representa un artículo del catálogo con sus propiedades y comportamiento
 */
class Producto
{
    private int $id;
    private string $nombre;
    private float $precio;
    private int $stock;
    private string $descripcion;

    /**
     * Constructor: inicializa un producto con sus datos
     *
     * @param int $id
     * @param string $nombre
     * @param float $precio
     * @param int $stock
     * @param string $descripcion
     */
    public function __construct(int $id, string $nombre, float $precio, int $stock, string $descripcion = '')
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->descripcion = $descripcion;
    }

    /**
     * Obtiene el ID del producto
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre del producto
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Obtiene el precio del producto
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Obtiene el precio formateado a euros
     */
    public function getPrecioFormateado(): string
    {
        return number_format($this->precio, 2, ',', '.') . ' €';
    }

    /**
     * Obtiene el stock disponible
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Obtiene la descripción
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Comprueba si hay stock suficiente para la cantidad solicitada
     *
     * @param int $cantidad
     * @return bool
     */
    public function tieneStockSuficiente(int $cantidad): bool
    {
        return $cantidad > 0 && $cantidad <= $this->stock;
    }

    /**
     * Reduce el stock del producto (cuando se compra)
     *
     * @param int $cantidad
     * @return bool
     */
    public function reducirStock(int $cantidad): bool
    {
        if (!$this->tieneStockSuficiente($cantidad)) {
            return false;
        }
        $this->stock -= $cantidad;
        return true;
    }

    /**
     * Devuelve un resumen corto del producto
     */
    public function getResumen(): string
    {
        return "{$this->nombre} ({$this->getPrecioFormateado()})";
    }

    /**
     * Devuelve los datos del producto como array (útil para serializar en sesión)
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'stock' => $this->stock,
            'descripcion' => $this->descripcion
        ];
    }

    /**
     * Crea un Producto a partir de un array (útil para recuperar de sesión)
     */
    public static function fromArray(array $datos): self
    {
        return new self(
            $datos['id'],
            $datos['nombre'],
            $datos['precio'],
            $datos['stock'],
            $datos['descripcion'] ?? ''
        );
    }
}
