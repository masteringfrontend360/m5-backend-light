<?php
declare(strict_types=1);

namespace App\Models\Interfaces;
interface CartStorageInterface {
    public function load(): array;
    public function save(array $items): void;
}