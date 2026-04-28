<?php

require_once __DIR__ . '/../config/config.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
    
        require $path; 
        
    }
});

use App\Controllers\ProductController;
use App\Controllers\CartController;

$action = $_GET['action'] ?? 'home';

switch ($action) {

    case 'home':
        (new ProductController())->index();
        break;

    case 'cart':
        (new CartController())->index();
        break;

    case 'process':
        (new CartController())->process();
        break;

    default:
        echo "404 - Página no encontrada";
}