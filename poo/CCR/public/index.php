<?php
// // 1. Reporte de errores (Para ver qué pasa)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// 2. CARGA DE ARCHIVOS (Primero las herramientas)// Carga el archivo (esto creará la variable $db dentro de este script)
require_once __DIR__ . '/../vendor/autoload.php'; // Si usas Composer, carga el autoload

// 3. NAMESPACES (Para no escribir rutas largas luego)
use App\Models\Carrito;
use App\Models\Producto;
use App\Storage\SessionCartStorage;
use App\Repositories\ProductoRepository;

// 4. SESIÓN (Importante: después de cargar las clases para que PHP sepa deserializar objetos)
session_start();

// 5. CONEXIÓN Y REPOSITORIO
// Usa el archivo de config o la línea directa, ¡pero solo una vez!
$db = require_once __DIR__ . '/../config/database.php'; 

$repo = new ProductoRepository($db);
$storage = new SessionCartStorage();
$carrito = $storage->load();

$mensaje = "";

// 2. Lógica de Acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'add') {
                $p = $repo->findById((int)$_POST['id']);
                if ($p) {
                    $carrito->añadir($p, (int)$_POST['cantidad']);
                    $mensaje = "Producto añadido!";
                }
            } elseif ($_POST['action'] === 'vaciar') {
                $carrito->vaciar();
            }
            $storage->save($carrito);
        }
    } catch (\Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

// 3. Cargar Datos para la Vista
$productos = $repo->getAll();
$itemsCarrito = $carrito->getItems();
$total = $carrito->getTotal();

// 4. Renderizar Vista
include __DIR__ . '/../Views/layout.php';