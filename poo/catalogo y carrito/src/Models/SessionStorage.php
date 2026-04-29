<?php
declare(strict_types=1);

namespace App\Models;
use App\Models\Interfaces\CartStorageInterface;

class SessionStorage implements CartStorageInterface {
    public function load(): array { return $_SESSION['carrito'] ?? []; }
    public function save(array $items): void { $_SESSION['carrito'] = $items; }
}