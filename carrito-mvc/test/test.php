<?php

require_once __DIR__ . '/../config/config.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) require $path;
});

use App\Models\Producto;
use App\Models\Carrito;

echo "TEST INICIADO\n";

$p1 = new Producto(1, "Laptop", 1000, 5);

$carrito = new Carrito([$p1]);

$result = $carrito->anadir(1, 2);

echo $result['mensaje'] . "\n";
echo "Total: " . $carrito->calcularTotal() . "\n";