<?php

/**
 * Carrito de compra
 * Muestra el resumen de productos añadidos y el total
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

// Obtener mensaje flash si lo hay
$mensaje = \CarritoPOO\obtenerMensajeFlash('mensaje');
$tipoMensaje = \CarritoPOO\obtenerMensajeFlash('tipo_mensaje');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compra - Tienda POO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .container-main {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 1.1rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table th {
            border: none;
            font-weight: 600;
            padding: 15px;
        }

        .table td {
            border: 1px solid #e5e7eb;
            padding: 15px;
            vertical-align: middle;
        }

        .resumen-compra {
            background: #f9fafb;
            border-radius: 12px;
            padding: 30px;
            margin-top: 40px;
        }

        .resumen-fila {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .resumen-fila:last-child {
            border-bottom: none;
        }

        .resumen-fila.total {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            padding-top: 20px;
            padding-bottom: 0;
            border-top: 3px solid #667eea;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 30px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: #ef4444;
            border: none;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .btn-group-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i>
                <strong>Tienda POO</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="carrito.php">
                            <i class="bi bi-cart3"></i> Carrito
                            <?php if (!$carrito->estaVacio()): ?>
                                <span class="badge bg-danger"><?php echo $carrito->getNumeroUnidades(); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container">
        <div class="container-main">
            <h1><i class="bi bi-cart3"></i> Carrito de Compra</h1>
            <p class="subtitle">Revisa tus productos seleccionados antes de comprar</p>

            <!-- Mensajes de alerta -->
            <?php if ($mensaje): ?>
                <div class="alert alert-<?php echo $tipoMensaje === 'exito' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-<?php echo $tipoMensaje === 'exito' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($carrito->estaVacio()): ?>
                <!-- Carrito vacío -->
                <div class="empty-cart">
                    <i class="bi bi-bag-x"></i>
                    <h3>Tu carrito está vacío</h3>
                    <p class="text-muted mb-4">No has añadido ningún producto todavía</p>
                    <a href="index.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-shop"></i> Continuar comprando
                    </a>
                </div>
            <?php else: ?>
                <!-- Tabla de productos en el carrito -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carrito->getItems() as $item): ?>
                                <?php echo \CarritoPOO\renderItemCarrito($item); ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Resumen de compra -->
                <div class="resumen-compra">
                    <h4 class="mb-3" style="color: #333;">Resumen de tu compra</h4>

                    <div class="resumen-fila">
                        <span>Número de artículos:</span>
                        <strong><?php echo $carrito->getNumeroUnidades(); ?></strong>
                    </div>

                    <div class="resumen-fila">
                        <span>Líneas de carrito:</span>
                        <strong><?php echo $carrito->getNumeroLineas(); ?></strong>
                    </div>

                    <div class="resumen-fila">
                        <span>Subtotal:</span>
                        <strong><?php echo number_format($carrito->calcularTotal(), 2, ',', '.'); ?> €</strong>
                    </div>

                    <?php
                    $iva = $carrito->calcularIVA();
                    if ($iva !== null):
                    ?>
                    <div class="resumen-fila">
                        <span>IVA (21%):</span>
                        <strong><?php echo number_format($iva, 2, ',', '.'); ?> €</strong>
                    </div>

                    <div class="resumen-fila">
                        <span>Envío:</span>
                        <span class="badge bg-success">Gratis</span>
                    </div>

                    <div class="resumen-fila total">
                        <span>Total:</span>
                        <strong><?php echo number_format($carrito->calcularTotalConIVA(), 2, ',', '.'); ?> €</strong>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Botones de acción -->
                <div class="btn-group-actions">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Continuar comprando
                    </a>
                    <form method="POST" action="procesar.php" style="display: inline;">
                        <button type="submit" name="accion" value="vaciar" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?');">
                            <i class="bi bi-trash"></i> Vaciar carrito
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary" onclick="alert('La funcionalidad de pago será implementada en futuras sesiones');">
                        <i class="bi bi-credit-card"></i> Proceder al pago
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
