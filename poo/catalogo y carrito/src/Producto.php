<?php
declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class Producto
{
    /**
     * @param int $precioCents El precio en centavos (ej: 1999 para 19.99€)
     */
    public function __construct(
        public readonly int $id,
        public readonly string $nombre,
        private int $precioCents,
        private int $stock,
    ) {
        // Validaciones preventivas
        if ($this->precioCents < 0) {
            throw new InvalidArgumentException("El precio no puede ser negativo.");
        }
        if ($this->stock < 0) {
            throw new InvalidArgumentException("El stock inicial no puede ser negativo.");
        }
    }

    // Método para sumar stock (aumentar inventario)
    public function addStock(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("La cantidad a añadir debe ser positiva.");
        }
        $this->stock += $quantity;
    }

    public function decreaseStock(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("La cantidad a descontar debe ser positiva.");
        }
        if ($this->stock < $quantity) {
            throw new \Exception("Stock insuficiente.");
        }
        $this->stock -= $quantity;
    }

    // Convertimos centavos a formato decimal solo al mostrar
    public function getPrecioDecimal(): float
    {
        return $this->precioCents / 100;
    }

    public function formatPrice(string $currency = '€'): string
    {
        return number_format($this->getPrecioDecimal(), 2, ',', '.') . ' ' . $currency;
    }
}