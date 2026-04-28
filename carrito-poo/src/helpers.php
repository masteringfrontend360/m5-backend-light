<?php

namespace CarritoPOO;

/**
 * Funciones auxiliares y globales
 */

/**
 * Autoloader simple para las clases del proyecto
 * Busca archivos en src/ basándose en el namespace
 */
spl_autoload_register(function ($clase) {
    // Reemplazar namespace por ruta
    $archivo = __DIR__ . '/' . str_replace('CarritoPOO\\', '', $clase) . '.php';

    if (file_exists($archivo)) {
        require_once $archivo;
    }
});

/**
 * Inicializa la sesión si no está ya iniciada
 */
function iniciarSesion(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Obtiene el carrito de la sesión o crea uno nuevo
 */
function obtenerCarritoSesion(Carrito $carritoConCatalogo): Carrito
{
    iniciarSesion();

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Crear carrito con el catálogo y los items guardados
    $carrito = $carritoConCatalogo;
    $carrito->setItems($_SESSION['carrito']);

    return $carrito;
}

/**
 * Guarda el carrito en la sesión
 */
function guardarCarritoSesion(Carrito $carrito): void
{
    iniciarSesion();
    $_SESSION['carrito'] = $carrito->getItemsRaw();
}

/**
 * Obtiene un mensaje flash de la sesión y lo elimina
 */
function obtenerMensajeFlash(string $clave = 'mensaje'): ?string
{
    iniciarSesion();

    if (isset($_SESSION[$clave])) {
        $mensaje = $_SESSION[$clave];
        unset($_SESSION[$clave]);
        return $mensaje;
    }

    return null;
}

/**
 * Guarda un mensaje flash en la sesión
 */
function guardarMensajeFlash(string $mensaje, string $clave = 'mensaje'): void
{
    iniciarSesion();
    $_SESSION[$clave] = $mensaje;
}

/**
 * Sanitiza entrada de usuario
 */
function sanitizar(string $entrada): string
{
    return htmlspecialchars(trim($entrada), ENT_QUOTES, 'UTF-8');
}

/**
 * Valida que un valor sea un número entero válido
 */
function esNumeroValido($valor): bool
{
    return is_numeric($valor) && (int)$valor > 0;
}

/**
 * Crea el catálogo inicial de productos
 */
function crearCatalogo(): array
{
    return [
        new Producto(
            1,
            'Laptop Dell',
            899.99,
            5,
            'Laptop de alta performance para desarrollo'
        ),
        new Producto(
            2,
            'Ratón Logitech',
            29.99,
            15,
            'Ratón inalámbrico ergonómico'
        ),
        new Producto(
            3,
            'Teclado Mecánico',
            149.99,
            8,
            'Teclado mecánico RGB para gaming'
        ),
        new Producto(
            4,
            'Monitor LG 4K',
            399.99,
            3,
            'Monitor ultrawide 34 pulgadas'
        ),
        new Producto(
            5,
            'Webcam HD',
            79.99,
            12,
            'Cámara web 1080p con micrófono'
        ),
        new Producto(
            6,
            'Hub USB-C',
            49.99,
            20,
            'Expansor de puertos USB-C 7 en 1'
        ),
    ];
}

/**
 * Renderiza un producto en HTML (componente reutilizable)
 */
function renderProducto(Producto $producto): string
{
    $id = $producto->getId();
    $nombre = htmlspecialchars($producto->getNombre());
    $descripcion = htmlspecialchars($producto->getDescripcion());
    $precio = $producto->getPrecioFormateado();
    $stock = $producto->getStock();
    $stockDisponible = $stock > 0 ? "<span class=\"badge badge-success\">{$stock} disponibles</span>" : "<span class=\"badge badge-danger\">Agotado</span>";
    $deshabilitado = $stock <= 0 ? 'disabled' : '';

    return <<<HTML
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">$nombre</h5>
                <p class="card-text text-muted">$descripcion</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="h5 mb-0 text-primary">$precio</span>
                    $stockDisponible
                </div>
                <form method="POST" action="procesar.php" class="row g-2">
                    <input type="hidden" name="producto_id" value="$id">
                    <div class="col">
                        <input type="number" name="cantidad" value="1" min="1" max="$stock" class="form-control form-control-sm" $deshabilitado required>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-sm w-100" $deshabilitado name="accion" value="anadir">
                            <i class="bi bi-cart-plus"></i> Añadir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
HTML;
}

/**
 * Renderiza un item del carrito en HTML
 */
function renderItemCarrito(array $item): string
{
    $producto = $item['producto'];
    $cantidad = $item['cantidad'];
    $subtotal = number_format($item['subtotal'], 2, ',', '.');
    $id = $producto->getId();
    $nombre = htmlspecialchars($producto->getNombre());
    $precio = $producto->getPrecioFormateado();

    return <<<HTML
    <tr>
        <td>
            <strong>$nombre</strong><br>
            <small class="text-muted">$precio</small>
        </td>
        <td class="text-center">$cantidad</td>
        <td class="text-end">$subtotal €</td>
        <td class="text-center">
            <form method="POST" action="procesar.php" style="display: inline;">
                <input type="hidden" name="producto_id" value="$id">
                <button type="submit" name="accion" value="eliminar" class="btn btn-danger btn-sm" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </td>
    </tr>
HTML;
}
