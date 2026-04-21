<?php
session_start();

// Si ya está logueado, no tiene sentido seguir viendo el login
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header('Location: index.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 01 · Login con sesión</title>
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

        .campo {
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input,
        button {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccd0d4;
            border-radius: 6px;
        }

        .hint {
            display: block;
            font-size: 14px;
            color: #666;
            margin-top: 6px;
        }

        button {
            background: #0073aa;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            width: auto;
            padding: 12px 18px;
        }

        button:hover {
            background: #005f8d;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .aviso {
            background: #fff8e5;
            border-left: 4px solid #dba617;
            padding: 12px 16px;
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
    <h1>Ejercicio 01 · Login con sesión</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> simular un acceso de usuario usando <code>$_SESSION</code>.</p>
        <p>Este archivo muestra el formulario de login. El usuario introduce email y contraseña, y los datos se enviarán a <code>index.php</code>, donde PHP validará las credenciales y decidirá si crea la sesión.</p>
        <p>En esta práctica trabajamos la idea de <strong>entrada de datos → validación → sesión → acceso protegido</strong>.</p>
    </div>

    <?php if ($flash): ?>
        <div class="<?php echo htmlspecialchars($flash['tipo']); ?>">
            <?php echo htmlspecialchars($flash['mensaje']); ?>
        </div>
    <?php endif; ?>

    <div class="aviso">
        <p><strong>Usuario de prueba:</strong></p>
        <p>Email: <code>ana@ejemplo.com</code><br>Contraseña: <code>1234</code></p>
    </div>

    <h2>Formulario de acceso</h2>

    <form action="index.php" method="POST" novalidate>
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <span class="hint">Debe coincidir con el usuario de prueba configurado en el ejercicio.</span>
        </div>

        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
            <span class="hint">En este ejercicio usamos una contraseña fija para practicar sesiones.</span>
        </div>

        <button type="submit">Iniciar sesión</button>
    </form>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>Arrancamos la sesión con <code>session_start()</code>.</li>
            <li>Si el usuario ya está logueado, lo redirigimos a <code>index.php</code>.</li>
            <li>Mostramos un formulario clásico enviado por <code>POST</code>.</li>
            <li>También pintamos mensajes flash guardados en sesión.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Qué aprender con este archivo</h2>
        <ul>
            <li>Cómo preparar una pantalla de acceso en PHP.</li>
            <li>Cómo evitar que un usuario autenticado vuelva al login.</li>
            <li>Cómo mostrar mensajes temporales con sesión.</li>
            <li>Cómo mantener una interfaz didáctica y clara para practicar backend ligero.</li>
        </ul>
    </div>
</div>

</body>
</html>