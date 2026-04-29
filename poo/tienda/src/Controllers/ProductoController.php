<?php

namespace App\Controllers;

use App\Models\ProductoRepositorio;
use App\Models\Carrito;

class ProductoController
{
    /**
     * GET /  —  muestra el catálogo completo.
     */
    public function index(): void
    {
        $productos = ProductoRepositorio::getAll();
        $carrito   = Carrito::cargarDesdeSesion();

        // Mensajes flash
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/productos/index.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }
}
