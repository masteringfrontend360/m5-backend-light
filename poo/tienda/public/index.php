<?php

declare(strict_types=1);

// ── Autoload y bootstrap ──────────────────────────────────────────
require_once __DIR__ . '/../config/autoload.php';

session_start();

// Base URL del subdirectorio (ej: "/tienda" si está en localhost/tienda)
// Vacío si está en la raíz del VirtualHost
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

// ── Router ───────────────────────────────────────────────────────
use App\Router;
use App\Controllers\ProductoController;
use App\Controllers\CarritoController;

$router = new Router();

// Catálogo
$router->get('/', function () {
    (new ProductoController())->index();
});

// Carrito — vistas
$router->get('/carrito', function () {
    (new CarritoController())->index();
});

// Carrito — acciones
$router->post('/carrito/agregar',  function () {
    (new CarritoController())->agregar();
});

$router->post('/carrito/eliminar', function () {
    (new CarritoController())->eliminar();
});

$router->post('/carrito/vaciar', function () {
    (new CarritoController())->vaciar();
});

// ── Despachar ─────────────────────────────────────────────────────
$metodo = $_SERVER['REQUEST_METHOD'];
$uri    = $_SERVER['REQUEST_URI'];

$router->despachar($metodo, $uri);
