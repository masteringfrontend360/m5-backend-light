<?php

/**
 * Catálogo de productos
 * Punto de entrada principal de la aplicación
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
    <title>Catálogo de Productos - Tienda POO</title>
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

        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #10b981;
            color: white;
        }

        .badge-danger {
            background-color: #ef4444;
            color: white;
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

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .float-shopping-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .badge-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .btn-carrito {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-carrito:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.4);
        }

        .text-primary {
            color: #667eea !important;
        }

        .h5 {
            color: #333;
            font-weight: 600;
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
                        <a class="nav-link active" href="index.php">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrito.php">
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
            <h1><i class="bi bi-tags"></i> Catálogo de Productos</h1>
            <p class="subtitle">Selecciona los productos que desees y añádelos al carrito</p>

            <!-- Mensajes de alerta -->
            <?php if ($mensaje): ?>
                <div class="alert alert-<?php echo $tipoMensaje === 'exito' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-<?php echo $tipoMensaje === 'exito' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Galería de productos -->
            <div class="row">
                <?php foreach ($catalogo as $producto): ?>
                    <?php echo \CarritoPOO\renderProducto($producto); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Botón flotante de carrito -->
    <div class="float-shopping-cart">
        <a href="carrito.php" class="btn btn-carrito" title="Ver carrito">
            <i class="bi bi-cart3"></i>
            <?php if (!$carrito->estaVacio()): ?>
                <span class="badge-count"><?php echo $carrito->getNumeroUnidades(); ?></span>
            <?php endif; ?>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
