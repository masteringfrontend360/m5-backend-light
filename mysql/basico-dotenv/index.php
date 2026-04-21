<?php
declare(strict_types=1);

session_start();

/*
|--------------------------------------------------------------------------
| Formulario didáctico + protección CSRF
|--------------------------------------------------------------------------
| Este archivo:
| 1. Muestra el formulario de alta de contactos
| 2. Genera un token CSRF para proteger el envío
| 3. Recupera mensajes flash y valores anteriores si existen
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['csrf_token_contactos'])
    || !is_string($_SESSION['csrf_token_contactos'])
    || $_SESSION['csrf_token_contactos'] === ''
) {
    $_SESSION['csrf_token_contactos'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token_contactos'];

$flash = $_SESSION['flash_contactos'] ?? null;
unset($_SESSION['flash_contactos']);

$old = $_SESSION['old_contactos'] ?? [];
unset($_SESSION['old_contactos']);

$oldNombre = htmlspecialchars((string) ($old['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
$oldEmail = htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8');
$oldCiudad = htmlspecialchars((string) ($old['ciudad'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica MySQL + phpdotenv · Añadir contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="box">
    <h1>Práctica MySQL + phpdotenv · Añadir contacto</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> enviar un formulario a PHP para guardar un contacto en MySQL, usando <code>phpdotenv</code> para cargar la configuración del entorno.</p>
        <p>En esta práctica mantenemos la misma lógica del proyecto básico, pero damos un paso más profesional: las credenciales ya no se leen con <code>parse_ini_file()</code>, sino con la librería <code>vlucas/phpdotenv</code> y el autoload de Composer.</p>
        <p>Seguimos trabajando el flujo completo: <strong>HTML → PHP → MySQL</strong>, pero con una base de configuración más moderna.</p>
    </div>

    <?php if (is_array($flash) && isset($flash['tipo'], $flash['mensaje'])): ?>
        <div class="<?php echo htmlspecialchars((string) $flash['tipo'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars((string) $flash['mensaje'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <h2>Formulario de contacto</h2>

    <form action="guardar.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                required
                maxlength="100"
                value="<?php echo $oldNombre; ?>"
                autocomplete="name"
            >
            <span class="hint">Campo obligatorio. Máximo 100 caracteres.</span>
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                maxlength="100"
                value="<?php echo $oldEmail; ?>"
                autocomplete="email"
            >
            <span class="hint">Campo obligatorio. Debe tener formato de email válido.</span>
        </div>

        <div class="campo">
            <label for="ciudad">Ciudad</label>
            <input
                type="text"
                id="ciudad"
                name="ciudad"
                maxlength="50"
                value="<?php echo $oldCiudad; ?>"
                autocomplete="address-level2"
            >
            <span class="hint">Campo opcional. Máximo 50 caracteres.</span>
        </div>

        <button type="submit">Guardar contacto</button>
    </form>

    <div class="acciones">
        <a class="boton-enlace boton-secundario" href="listado.php">Ver todos los contactos</a>
    </div>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>El formulario usa <code>method="POST"</code> para enviar datos al servidor.</li>
            <li>El archivo de destino es <code>guardar.php</code>.</li>
            <li>Generamos un token <code>CSRF</code> y lo enviamos oculto en el formulario.</li>
            <li>Si el envío falla, podemos recuperar los datos anteriores y volver a pintarlos.</li>
            <li>Después, otro archivo PHP se encargará de validar e insertar en la base de datos.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Qué cambia respecto a la práctica básica</h2>
        <ul>
            <li>La lógica visual del formulario es prácticamente la misma.</li>
            <li>La diferencia importante está en <code>conexion.php</code>, donde ahora usamos <code>vendor/autoload.php</code> y <code>phpdotenv</code>.</li>
            <li>Esto se parece más a cómo se organiza la configuración en proyectos PHP modernos.</li>
        </ul>
    </div>
</div>

</body>
</html>