<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Shop PHP</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">Mini Shop PHP</a>
        <nav>
            <a href="index.php">Catálogo</a>
            <a href="index.php?action=cart">Carrito</a>
        </nav>
    </div>
</header>

<main class="container">
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>