<?php

namespace App\Services;

use App\Models\Producto;

class CatalogoService {

    public static function getCatalogo() {

        return [
            new Producto(1, "Laptop", 1000, 5),
            new Producto(2, "Mouse", 25, 10),
            new Producto(3, "Teclado", 50, 8),
        ];
    }
}