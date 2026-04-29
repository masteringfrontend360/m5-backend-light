<?php

namespace App\Controllers;

use App\Models\Carrito;
use App\Models\ProductoRepositorio;

class CarritoController
{
    /**
     * GET /carrito  —  muestra el resumen del carrito.
     */
    public function index(): void
    {
        $carrito = Carrito::cargarDesdeSesion();

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/carrito/index.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    /**
     * POST /carrito/agregar  —  añade un producto al carrito.
     */
    public function agregar(): void
    {
        $idProducto = (int) ($_POST['producto_id'] ?? 0);
        $cantidad   = (int) ($_POST['cantidad']    ?? 1);

        $producto = ProductoRepositorio::getById($idProducto);

        if (!$producto) {
            $_SESSION['flash'] = ['tipo' => 'error', 'texto' => 'Producto no encontrado.'];
            $this->redirigir('/');
            return;
        }

        $carrito    = Carrito::cargarDesdeSesion();
        $resultado  = $carrito->agregarProducto($producto, $cantidad);

        $carrito->guardarEnSesion();

        $_SESSION['flash'] = [
            'tipo'  => $resultado['ok'] ? 'exito' : 'error',
            'texto' => $resultado['mensaje'],
        ];

        $this->redirigir('/');
    }

    /**
     * POST /carrito/eliminar  —  elimina una línea del carrito.
     */
    public function eliminar(): void
    {
        $idProducto = (int) ($_POST['producto_id'] ?? 0);

        $carrito = Carrito::cargarDesdeSesion();
        $carrito->eliminarProducto($idProducto);
        $carrito->guardarEnSesion();

        $_SESSION['flash'] = ['tipo' => 'exito', 'texto' => 'Producto eliminado del carrito.'];
        $this->redirigir('/carrito');
    }

    /**
     * POST /carrito/vaciar  —  vacía el carrito.
     */
    public function vaciar(): void
    {
        $carrito = Carrito::cargarDesdeSesion();
        $carrito->vaciar();
        $carrito->guardarEnSesion();

        $_SESSION['flash'] = ['tipo' => 'exito', 'texto' => 'El carrito ha sido vaciado.'];
        $this->redirigir('/carrito');
    }

    // ──────────────────────────────────────────
    //  Helpers privados
    // ──────────────────────────────────────────

    private function redirigir(string $url): void
    {
        $base = defined('BASE_URL') ? BASE_URL : '';
        header("Location: {$base}{$url}");
        exit;
    }
}
