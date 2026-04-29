<?php

declare(strict_types=1);

namespace App\Models;

class ProductRepository
{
    /**
     * @return Product[]
     */
    public function all(): array
    {
        return [
            new Product(1, 'Teclado mecánico', 79.95, 5),
            new Product(2, 'Ratón gaming', 39.90, 8),
            new Product(3, 'Monitor 24 pulgadas', 159.00, 3),
            new Product(4, 'Auriculares inalámbricos', 89.50, 6),
        ];
    }

    public function findById(int $id): ?Product
    {
        foreach ($this->all() as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }

        return null;
    }
}