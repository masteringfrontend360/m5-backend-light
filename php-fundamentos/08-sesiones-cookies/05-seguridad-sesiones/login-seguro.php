<?php
ob_start();
session_start();

$usuarioValido = [
    'email' => 'ana@ejemplo.com',
    'password' => '1234',
    'nombre' => 'Ana',
];

$errores = [];
$mensajeExito = null;
$usuarioLogueado = isset($_SESSION['seguro_logueado']) && $_SESSION['seguro_logueado'] === true;

// Proceso de login seguro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '') {
        $errores[] = 'El email es obligatorio.';
    }

    if ($password === '') {
        $errores[] = 'La contraseña es obligatoria.';
    }

    if (empty($errores)) {
        if ($email === $usuarioValido['email'] && $password === $usuarioValido['password']) {
            session_regenerate_id(true);

            $_SESSION['seguro_logueado'] = true;
            $_SESSION['seguro_nombre'] = $usuarioValido['nombre'];
            $_SESSION['seguro_email'] = $usuarioValido['email'];

            $usuarioLogueado = true;
            $mensajeExito = 'Login seguro correcto. Se ha regenerado el identificador de sesión.';
        } else {
            $errores[] = 'Credenciales incorrectas.';
        }
    }
}

// Logout simple para poder repetir pruebas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'logout') {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 3600,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }

    session_destroy();
    session_start();

    $usuarioLogueado = false;
    $mensajeExito = 'Sesión cerrada. Ya puedes volver a probar el login seguro.';
}

$nombreUsuario = htmlspecialchars($_SESSION['seguro_nombre'] ?? 'Ana');
$emailUsuario = htmlspecialchars($_SESSION['seguro_email'] ?? 'ana@ejemplo.com');

$sessionCookieParams = session_get_cookie_params();
$cookieHttpOnly = ini_get('session.cookie_httponly');
$cookieSecure = ini_get('session.cookie_secure');
$sessionUseCookies = ini_get('session.use_cookies');
$sessionUseOnlyCookies = ini_get('session.use_only_cookies');
$sessionName = session_name();
$sessionId = session_id();

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 05 · Seguridad de sesiones</title>
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
            max-width: 980px;
        }

        h1, h2, h3 {
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

        .boton-secundario {
            background: #50575e;
        }

        .boton-secundario:hover {
            background: #3c434a;
        }

        .hint {
            display: block;
            font-size: 14px;
            color: #666;
            margin-top: 6px;
        }

        .ok {
            background: #edfaef;
            border-left: 4px solid #00a32a;
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .error {
            background: #fff1f1;
            border-left: 4px solid #d63638;
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .panel {
            background: #f9f9f9;
            border-left: 4px solid #72aee6;
            padding: 18px 20px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 18px;
        }

        .grid-datos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
        }

        .dato {
            background: #ffffff;
            border: 1px solid #dcdcde;
            border-radius: 6px;
            padding: 12px 14px;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        ul {
            padding-left: 20px;
        }

        @media (max-width: 720px) {
            .grid-datos {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Ejercicio 05 · Seguridad de sesiones</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> reforzar el login anterior con medidas básicas de seguridad de sesión.</p>
        <p>La idea central aquí es entender por qué <code>session_regenerate_id(true)</code> es importante al iniciar sesión y cómo revisar algunos parámetros de seguridad relacionados con la cookie de sesión.</p>
        <p>Además, mantenemos el estilo didáctico para que se vea claramente qué está pasando y qué valores tiene tu entorno PHP.</p>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="error">
            <strong>Se han detectado errores:</strong>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($mensajeExito): ?>
        <div class="ok">
            <?php echo htmlspecialchars($mensajeExito); ?>
        </div>
    <?php endif; ?>

    <?php if (!$usuarioLogueado): ?>
        <h2>Login seguro</h2>

        <form method="POST" action="">
            <input type="hidden" name="accion" value="login">

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <span class="hint">Usuario de prueba: <code>ana@ejemplo.com</code></span>
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
                <span class="hint">Contraseña de prueba: <code>1234</code></span>
            </div>

            <button type="submit">Iniciar sesión de forma segura</button>
        </form>
    <?php else: ?>
        <div class="panel">
            <h2>Sesión segura iniciada</h2>
            <p><strong>Usuario:</strong> <?php echo $nombreUsuario; ?></p>
            <p><strong>Email:</strong> <?php echo $emailUsuario; ?></p>
            <p><strong>Nombre de sesión:</strong> <?php echo htmlspecialchars($sessionName); ?></p>
            <p><strong>ID de sesión actual:</strong> <?php echo htmlspecialchars($sessionId); ?></p>

            <form method="POST" action="" style="margin-top: 20px;">
                <input type="hidden" name="accion" value="logout">
                <button type="submit" class="boton-secundario">Cerrar sesión y volver a probar</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>Comprobamos email y contraseña de un usuario fijo de prueba.</li>
            <li>Si el login es correcto, llamamos a <code>session_regenerate_id(true)</code>.</li>
            <li>Eso genera un nuevo identificador de sesión y reduce riesgos como la fijación de sesión.</li>
            <li>Después guardamos los datos del usuario en <code>$_SESSION</code>.</li>
            <li>También permitimos cerrar sesión para repetir la prueba todas las veces que quieras.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Por qué importa session_regenerate_id(true)</h2>
        <ul>
            <li>Cuando un usuario pasa de anónimo a autenticado, conviene cambiar el ID de sesión.</li>
            <li>Así evitamos reutilizar un identificador previo que pudiera haber sido fijado o conocido por un tercero.</li>
            <li>Es una práctica básica de seguridad en cualquier login con sesiones.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Valores de seguridad de la sesión en tu entorno</h2>

        <div class="grid-datos">
            <div class="dato">
                <strong>session.cookie_httponly</strong><br>
                <?php echo htmlspecialchars((string) $cookieHttpOnly); ?>
            </div>

            <div class="dato">
                <strong>session.cookie_secure</strong><br>
                <?php echo htmlspecialchars((string) $cookieSecure); ?>
            </div>

            <div class="dato">
                <strong>session.use_cookies</strong><br>
                <?php echo htmlspecialchars((string) $sessionUseCookies); ?>
            </div>

            <div class="dato">
                <strong>session.use_only_cookies</strong><br>
                <?php echo htmlspecialchars((string) $sessionUseOnlyCookies); ?>
            </div>

            <div class="dato">
                <strong>Cookie path</strong><br>
                <?php echo htmlspecialchars((string) ($sessionCookieParams['path'] ?? '')); ?>
            </div>

            <div class="dato">
                <strong>Cookie lifetime</strong><br>
                <?php echo htmlspecialchars((string) ($sessionCookieParams['lifetime'] ?? '')); ?>
            </div>
        </div>
    </div>

    <div class="mini-box">
        <h2>Qué deberías observar</h2>
        <ul>
            <li>Si el login va bien, verás una sesión activa con un ID concreto.</li>
            <li>En un entorno bien endurecido, <code>session.cookie_httponly</code> debería estar activado.</li>
            <li><code>session.cookie_secure</code> suele estar activo cuando trabajas bajo HTTPS.</li>
            <li>En local con <code>http://localhost</code>, es normal que <code>secure</code> no esté activado.</li>
        </ul>
    </div>
</div>

</body>
</html>