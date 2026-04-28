<?php

namespace App\Controllers;

use App\Services\CatalogoService;
use App\Services\SessionService;
use App\Models\Carrito;

class ProductController {

    public function index() {

        SessionService::start();

        $catalogo = CatalogoService::getCatalogo();

        $carrito = SessionService::get('carrito')
            ?? new Carrito($catalogo);

        SessionService::set('carrito', $carrito);

        require __DIR__ . '/../../views/Products/index.php';
    }
}