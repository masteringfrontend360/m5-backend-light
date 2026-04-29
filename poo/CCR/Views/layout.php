<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Pro - POO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">🛍️ TechStore</a>
        <div class="d-flex">
            <a href="index.php?view=carrito" class="btn btn-outline-light position-relative">
                <i class="bi bi-cart3"></i> Carrito
                <?php if ($carrito->getTotalUnidades() > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $carrito->getTotalUnidades() ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>

<main class="container">
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($mensaje) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php 
    // Lógica de enrutamiento simple para las vistas
    $view = $_GET['view'] ?? 'catalogo';
    if ($view === 'carrito') {
        include '../Views/carrito_resumen.php';
    } else {
        include '../Views/catalogo.php';
    }
    ?>
</main>

<footer class="text-center py-4 mt-5 text-muted border-top">
    &copy; <?= date('Y') ?> Práctica POO Avanzada - MVC
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>