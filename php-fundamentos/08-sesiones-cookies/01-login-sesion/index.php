<?php
session_start();

// Usuario fijo de prueba para el ejercicio
$usuarioValido = [
    'email' => 'ana@ejemplo.com',
    'password' => '1234',
    'nombre' => 'Ana',
];

// Si llega el formulario por POST, intentamos validar el login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === $usuarioValido['email'] && $password === $usuarioValido['password']) {
        session_regenerate_id(true);

        $_SESSION['logueado'] = true;
        $_SESSION['usuario_nombre'] = $usuarioValido['nombre'];
        $_SESSION['usuario_email'] = $usuarioValido['email'];
        $_SESSION['flash'] = [
            'tipo' => 'ok',
            'mensaje' => 'Login correcto. Ya has iniciado sesión.',
        ];

        header('Location: index.php');
        exit;
    }

    $_SESSION['flash'] = [
        'tipo' => 'error',
        'mensaje' => 'Credenciales incorrectas. Revisa el email y la contraseña.',
    ];

    header('Location: login.php');
    exit;
}

// Si no está logueado, no puede ver esta página
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    $_SESSION['flash'] = [
        'tipo' => 'error',
        'mensaje' => 'Debes iniciar sesión para acceder al panel.',
    ];

    header('Location: login.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$nombreUsuario = htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario');
$emailUsuario = htmlspecialchars($_SESSION['usuario_email'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 01 · Panel con sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
            color: #333;
        }

        .box {
            background: #ffffff;
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 860px;
        }

        h1, h2 {
            margin-top: 0;
            color: #1d2327;
        }

        p {
            line-height: 1.6;
        }

        .intro {
            background: #eef4ff;
            border-left: 4px solid #2271b1;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .ok {
            background: #edfaef;
            border-left: 4px solid #00a32a;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #fff1f1;
            border-left: 4px solid #d63638;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .panel {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 18px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .acciones a {
            display: inline-block;
            text-decoration: none;
            background: #0073aa;
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            font-weight: bold;
        }

        .acciones a:hover {
            background: #005f8d;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Ejercicio 01 · Panel principal con sesión</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> proteger una página para que solo pueda verla un usuario autenticado.</p>
        <p>Este archivo cumple dos papeles: procesa el login cuando llega el formulario por <code>POST</code> y, si la sesión ya existe, muestra el panel privado del usuario.</p>
        <p>Aquí practicamos <code>session_start()</code>, validación básica de credenciales, <code>session_regenerate_id(true)</code>, redirecciones con <code>header()</code> y control de acceso con <code>$_SESSION</code>.</p>
    </div>

    <?php if ($flash): ?>
        <div class="<?php echo htmlspecialchars($flash['tipo']); ?>">
            <?php echo htmlspecialchars($flash['mensaje']); ?>
        </div>
    <?php endif; ?>

    <div class="panel">
        <h2>¡Bienvenida, <?php echo $nombreUsuario; ?>!</h2>
        <p><strong>Email del usuario:</strong> <?php echo $emailUsuario; ?></p>
        <p>Has accedido correctamente al área privada del ejercicio.</p>

        <div class="acciones">
            <a href="../02-carrito-sesion/carrito.php">Ver carrito</a>
            <a href="../03-preferencias-cookies/preferencias.php">Preferencias</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>Si el formulario llega por <code>POST</code>, PHP compara email y contraseña con un usuario fijo.</li>
            <li>Si son correctos, se crea la sesión del usuario.</li>
            <li>Usamos <code>session_regenerate_id(true)</code> para reforzar la seguridad tras el login.</li>
            <li>Si no hay sesión activa, esta página redirige automáticamente al login.</li>
            <li>Si la sesión existe, se muestra el panel privado.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Ideas importantes del ejercicio</h2>
        <ul>
            <li><code>$_SESSION</code> sirve para guardar información entre páginas.</li>
            <li>No basta con mostrar un login: también hay que proteger las páginas internas.</li>
            <li>Después de <code>header('Location: ...')</code> siempre usamos <code>exit;</code>.</li>
            <li>En los <code>echo</code> mostramos los datos con <code>htmlspecialchars()</code>.</li>
        </ul>
    </div>
</div>

</body>
</html>