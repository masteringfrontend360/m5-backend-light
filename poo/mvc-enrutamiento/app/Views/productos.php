<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
</head>
<body>
 <nav>
    <a href="<?= BASE_URL ?>">Inicio</a>
    <a href="<?= BASE_URL ?>productos">Productos</a>
    <a href="<?= BASE_URL ?>contacto">Contacto</a>
</nav>
    <h1><?= $titulo ?></h1>

    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <?= htmlspecialchars($producto['nombre']) ?> -
                <?= number_format($producto['precio'], 2) ?> €
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>