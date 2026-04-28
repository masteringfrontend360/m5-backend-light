<?php

/**
 * Procesador de acciones del carrito
 * Maneja añadir, eliminar y vaciar productos
 * Redirige a la página correspondiente después
 */

require_once __DIR__ . '/../src/helpers.php';

use CarritoPOO\{Producto, Carrito};

// Iniciar sesión
\CarritoPOO\iniciarSesion();

// Crear catálogo de productos
$catalogo = \CarritoPOO\crearCatalogo();

// Obtener carrito de sesión
$carritoConCatalogo = new Carrito($catalogo);
$carrito = \CarritoPOO\obtenerCarritoSesion($carritoConCatalogo);

// Establecer URL de redirección por defecto
$redirigirA = 'index.php';

// Procesar la acción solicitada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;

    switch ($accion) {
        case 'anadir':
            // Añadir producto al carrito
            $productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
            $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;

            // Validar que los datos sean válidos
            if ($productoId > 0 && \CarritoPOO\esNumeroValido($cantidad)) {
                $resultado = $carrito->anadir($productoId, $cantidad);

                if ($resultado['exito']) {
                    \CarritoPOO\guardarMensajeFlash(
                        $resultado['mensaje'],
                        'mensaje'
                    );
                    \CarritoPOO\guardarMensajeFlash('exito', 'tipo_mensaje');
                } else {
                    \CarritoPOO\guardarMensajeFlash(
                        $resultado['mensaje'],
                        'mensaje'
                    );
                    \CarritoPOO\guardarMensajeFlash('error', 'tipo_mensaje');
                }
            } else {
                \CarritoPOO\guardarMensajeFlash(
                    'Datos inválidos en el formulario',
                    'mensaje'
                );
                \CarritoPOO\guardarMensajeFlash('error', 'tipo_mensaje');
            }

            // Guardar carrito en sesión
            \CarritoPOO\guardarCarritoSesion($carrito);
            break;

        case 'eliminar':
            // Eliminar producto del carrito completamente
            $productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;

            if ($productoId > 0) {
                // Buscar el producto para obtener su nombre
                $producto = null;
                foreach ($catalogo as $p) {
                    if ($p->getId() === $productoId) {
                        $producto = $p;
                        break;
                    }
                }

                if ($carrito->eliminar($productoId)) {
                    $nombreProducto = $producto ? $producto->getNombre() : 'Producto';
                    \CarritoPOO\guardarMensajeFlash(
                        $nombreProducto . ' eliminado del carrito',
                        'mensaje'
                    );
                    \CarritoPOO\guardarMensajeFlash('exito', 'tipo_mensaje');
                } else {
                    \CarritoPOO\guardarMensajeFlash(
                        'No se pudo eliminar el producto',
                        'mensaje'
                    );
                    \CarritoPOO\guardarMensajeFlash('error', 'tipo_mensaje');
                }

                \CarritoPOO\guardarCarritoSesion($carrito);
            }

            $redirigirA = 'carrito.php';
            break;

        case 'vaciar':
            // Vaciar todo el carrito
            $carrito->vaciar();
            \CarritoPOO\guardarCarritoSesion($carrito);
            \CarritoPOO\guardarMensajeFlash(
                'Carrito vaciado correctamente',
                'mensaje'
            );
            \CarritoPOO\guardarMensajeFlash('exito', 'tipo_mensaje');
            $redirigirA = 'carrito.php';
            break;

        case 'reducir':
            // Reducir cantidad de un producto
            $productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
            $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

            if ($productoId > 0 && $cantidad > 0) {
                $resultado = $carrito->reducirCantidad($productoId, $cantidad);

                if ($resultado['exito']) {
                    \CarritoPOO\guardarMensajeFlash(
                        $resultado['mensaje'],
                        'mensaje'
                    );
                    \CarritoPOO\guardarMensajeFlash('exito', 'tipo_mensaje');
                } else {
                    \CarritoPOO\guardarMensajeFlash(
                        $resultado['mensaje'],
                        'mensaje'
                    );
                    \CarritoPOO\guardarMensajeFlash('error', 'tipo_mensaje');
                }

                \CarritoPOO\guardarCarritoSesion($carrito);
            }

            $redirigirA = 'carrito.php';
            break;

        default:
            \CarritoPOO\guardarMensajeFlash(
                'Acción no reconocida',
                'mensaje'
            );
            \CarritoPOO\guardarMensajeFlash('error', 'tipo_mensaje');
    }
}

// Redirigir a la página apropiad
header('Location: ' . $redirigirA);
exit;
