<?php
session_start();

$errores = $_SESSION['errores'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errores'], $_SESSION['old']);

// htmlspecialchars evita XSS cuando muestras contenido del usuario en la página
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario clásico con PHP</title>
</head>
<body>
    <h1>Formulario clásico</h1>
    <p>Ejemplo de validación en PHP con sesiones.</p>

    

    <form action="proceso.php" method="POST" novalidate>
    <div>
        <label for="nombre">Nombre</label><br>
        <input
            type="text"
            id="nombre"
            name="nombre"
            value="<?= htmlspecialchars($old['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
        <?php if (isset($errores['nombre'])): ?>
            <p><?= htmlspecialchars($errores['nombre'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <br>

    <div>
        <label for="email">Email</label><br>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        >
        <?php if (isset($errores['email'])): ?>
            <p><?= htmlspecialchars($errores['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>

    <br>

    <button type="submit">Enviar</button>
</form>
</body>
</html>
                