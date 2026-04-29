<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Si usas Composer

use App\Models\{Carrito, SessionStorage, Producto};
use App\Controllers\ShopController;

session_start();

// Setup (Esto en Laravel lo hace el framework por ti)
$storage = new SessionStorage();
$cart = new Carrito($storage);
$catalog = [
    1 => new Producto(1, 'Laptop', 99900, 5),
    2 => new Producto(2, 'Ratón', 2500, 10)
];

// Ejecución
$controller = new ShopController($cart, $catalog);
$controller->index();