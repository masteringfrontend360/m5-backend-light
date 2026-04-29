<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Representa una línea del carrito de compra.
 *
 * Un CartItem agrupa un producto concreto y la cantidad añadida al carrito.
 * Su responsabilidad es encapsular esos datos y ofrecer operaciones
 * relacionadas con esa línea, como calcular el subtotal.
 */
class CartItem
{
    /**
     * Crea una nueva línea de carrito.
     *
     * @param Product $product Producto asociado a esta línea del carrito.
     * @param int $quantity Cantidad de unidades del producto.
     */
    public function __construct(
        private Product $product,
        private int $quantity
    ) {
    }

    /**
     * Devuelve el producto asociado a esta línea del carrito.
     *
     * @return Product Producto contenido en la línea.
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Devuelve la cantidad de unidades del producto.
     *
     * @return int Cantidad actual de productos en esta línea.
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Actualiza la cantidad de unidades del producto.
     *
     * Este método modifica el estado interno del objeto para reflejar
     * una nueva cantidad dentro del carrito.
     *
     * @param int $quantity Nueva cantidad de productos.
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Calcula el subtotal de esta línea del carrito.
     *
     * El subtotal se obtiene multiplicando el precio del producto
     * por la cantidad seleccionada.
     *
     * @return float Importe subtotal de esta línea.
     */
    public function getSubtotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }
}