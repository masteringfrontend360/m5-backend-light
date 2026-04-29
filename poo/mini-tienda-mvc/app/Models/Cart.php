<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Session;

class Cart
{
    private const SESSION_KEY = 'cart';

    /**
     * @var CartItem[]
     */
    private array $items = [];

    public function __construct(private Session $session)
    {
        $storedItems = $this->session->get(self::SESSION_KEY, []);

        if (is_array($storedItems)) {
            $this->items = $storedItems;
        }
    }

    /**
     * @return CartItem[]
     */
    public function all(): array
    {
        return $this->items;
    }

    public function add(Product $product, int $quantity): array
    {
        if ($quantity <= 0) {
            return [
                'success' => false,
                'message' => 'La cantidad debe ser mayor que 0.',
            ];
        }

        $currentQuantity = $this->getQuantityByProductId($product->getId());
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->getStock()) {
            return [
                'success' => false,
                'message' => 'No puedes añadir más unidades de las disponibles en stock.',
            ];
        }

        $found = false;

        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                $item->setQuantity($newQuantity);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->items[] = new CartItem($product, $quantity);
        }

        $this->sync();

        return [
            'success' => true,
            'message' => 'Producto añadido al carrito correctamente.',
        ];
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }

        return $total;
    }

    public function getTotalItems(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    private function getQuantityByProductId(int $productId): int
    {
        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $productId) {
                return $item->getQuantity();
            }
        }

        return 0;
    }

    private function sync(): void
    {
        $this->session->set(self::SESSION_KEY, $this->items);
    }
}