<?php

namespace App\Controllers;

use App\Services\SessionService;
use App\Services\FlashService;
use App\Services\CatalogoService;
use App\Models\Carrito;

class CartController {

    public function index() {

        SessionService::start();

        $catalogo = CatalogoService::getCatalogo();

        $carrito = SessionService::get('carrito')
            ?? new Carrito($catalogo);

        $mensaje = FlashService::get('mensaje');
        $tipo_mensaje = FlashService::get('tipo_mensaje');

        require __DIR__ . '/../../views/Cart/index.php';
    }

    public function process() {

        SessionService::start();

        $catalogo = CatalogoService::getCatalogo();

        $carrito = SessionService::get('carrito')
            ?? new Carrito($catalogo);

        $accion = $_POST['accion'] ?? null;

        switch ($accion) {

            case 'anadir':
                $resultado = $carrito->anadir((int)$_POST['producto_id'], (int)$_POST['cantidad']);
                FlashService::set('mensaje', $resultado['mensaje']);
                FlashService::set('tipo_mensaje', $resultado['exito'] ? 'success' : 'error');
                break;

            case 'eliminar':
                $carrito->eliminar((int)$_POST['producto_id']);
                FlashService::set('mensaje', 'Producto eliminado');
                FlashService::set('tipo_mensaje', 'success');
                break;

            case 'vaciar':
                $carrito->vaciar();
                FlashService::set('mensaje', 'Carrito vaciado');
                FlashService::set('tipo_mensaje', 'success');
                break;
        }

        SessionService::set('carrito', $carrito);

        header("Location: index.php?action=cart");
    }
}