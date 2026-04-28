<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda POO</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

<nav>
    <div><strong>Tienda POO</strong></div>
    <div>
        <a href="index.php">Catálogo</a>
        <a href="index.php?action=cart">Carrito</a>
    </div>
</nav>

<div class="container">
    <?= $content ?>
</div>

</body>
</html>