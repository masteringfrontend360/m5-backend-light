<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\CartStorageInterface;
use App\Models\Producto;
class Carrito
{
    private array $items = [];

    // Inyectamos el almacenamiento (Dependency Injection)
    public function __construct(private CartStorageInterface $storage)
    {
        $this->items = $this->storage->load();
    }

    public function add(Producto $producto, int $cantidad): void
    {
        if ($cantidad <= 0) throw new \InvalidArgumentException("Cantidad inválida.");
        
        if (!$producto->hasStock($cantidad)) {
            throw new \RuntimeException("Stock insuficiente para: {$producto->nombre}");
        }

        $id = $producto->id;
        $this->items[$id] = ($this->items[$id] ?? 0) + $cantidad;
        $this->persistir();
    }

    public function calcularTotal(array $catalogo): int
    {
        $totalCents = 0;
        foreach ($this->items as $id => $cantidad) {
            // Si el producto no está en el catálogo, lanzamos error
            if (!isset($catalogo[$id])) {
                throw new \OutOfBoundsException("Producto con ID $id en el carrito no existe en el catálogo.");
            }
            
            // Asumimos que Producto ahora tiene getPrecioCents(): int
            $totalCents += ($catalogo[$id]->getPrecioCents()) * $cantidad;
        }
        return $totalCents;
    }

    private function persistir(): void
    {
        $this->storage->save($this->items);
    }
}