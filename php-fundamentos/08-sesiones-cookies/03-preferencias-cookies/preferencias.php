<?php
ob_start();
session_start();

// Protegemos la página: solo puede entrar un usuario con sesión activa
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    $_SESSION['flash'] = [
        'tipo' => 'error',
        'mensaje' => 'Debes iniciar sesión para acceder a preferencias.',
    ];

    header('Location: ../01-login-sesion/login.php');
    exit;
}

$idiomasPermitidos = ['ES', 'EN'];
$idiomaActual = $_COOKIE['idioma'] ?? 'ES';

// Si llega algo raro por cookie, forzamos ES
if (!in_array($idiomaActual, $idiomasPermitidos, true)) {
    $idiomaActual = 'ES';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idiomaRecibido = $_POST['idioma'] ?? '';

    if (in_array($idiomaRecibido, $idiomasPermitidos, true)) {
        setcookie(
            'idioma',
            $idiomaRecibido,
            [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );

        $_SESSION['flash'] = [
            'tipo' => 'ok',
            'mensaje' => 'Preferencia de idioma guardada correctamente.',
        ];

        header('Location: preferencias.php');
        exit;
    }

    $_SESSION['flash'] = [
        'tipo' => 'error',
        'mensaje' => 'El idioma enviado no es válido.',
    ];

    header('Location: preferencias.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$idiomaTexto = $idiomaActual === 'EN' ? 'Inglés' : 'Español';
$idiomaAlternativo = $idiomaActual === 'ES' ? 'EN' : 'ES';
$idiomaAlternativoTexto = $idiomaAlternativo === 'EN' ? 'Inglés' : 'Español';

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 03 · Preferencias con cookies</title>
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
            max-width: 920px;
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

        .preferencia-box {
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

        button,
        .boton-enlace {
            background: #0073aa;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            width: auto;
            padding: 12px 18px;
            text-decoration: none;
            display: inline-block;
            border-radius: 6px;
            font-size: 16px;
        }

        button:hover,
        .boton-enlace:hover {
            background: #005f8d;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .estado-idioma {
            font-size: 18px;
            margin-bottom: 12px;
        }

        .chip {
            display: inline-block;
            background: #edfaef;
            color: #0a4b1a;
            border: 1px solid #b8e6c3;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-left: 8px;
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
    <h1>Ejercicio 03 · Preferencias con cookies</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> guardar una preferencia del usuario en una <code>cookie</code>, en este caso el idioma.</p>
        <p>Este ejercicio muestra cómo PHP puede leer una cookie existente, actualizarla cuando el usuario cambia una opción y redirigir después para evitar reenvíos accidentales del formulario.</p>
        <p>Aquí practicamos <code>setcookie()</code>, <code>$_COOKIE</code>, <code>in_array()</code>, mensajes flash con sesión y <code>ob_start()</code>.</p>
    </div>

    <?php if ($flash): ?>
        <div class="<?php echo htmlspecialchars($flash['tipo']); ?>">
            <?php echo htmlspecialchars($flash['mensaje']); ?>
        </div>
    <?php endif; ?>

    <div class="preferencia-box">
        <h2>Idioma actual</h2>

        <p class="estado-idioma">
            <strong>Preferencia guardada:</strong>
            <?php echo htmlspecialchars($idiomaTexto); ?>
            <span class="chip">Activa</span>
        </p>

        <p>La cookie actual tiene el valor <code><?php echo htmlspecialchars($idiomaActual); ?></code>.</p>

        <form method="POST" action="">
            <input type="hidden" name="idioma" value="<?php echo htmlspecialchars($idiomaAlternativo); ?>">

            <div class="acciones">
                <button type="submit">Cambiar a <?php echo htmlspecialchars($idiomaAlternativoTexto); ?></button>
                <a class="boton-enlace" href="../01-login-sesion/index.php">Volver al panel</a>
            </div>
        </form>
    </div>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>Leemos la cookie <code>idioma</code> con <code>$_COOKIE['idioma'] ?? 'ES'</code>.</li>
            <li>Si no existe, usamos <code>ES</code> como valor por defecto.</li>
            <li>Cuando el usuario pulsa el botón, enviamos por <code>POST</code> el idioma contrario.</li>
            <li>PHP valida que el valor esté dentro de los idiomas permitidos con <code>in_array()</code>.</li>
            <li>Después guardamos la cookie y redirigimos a la misma página.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Por qué redirigimos a la misma página</h2>
        <ul>
            <li>Así evitamos reenviar el formulario al refrescar el navegador.</li>
            <li>También conseguimos que la cookie recién guardada se lea ya en una nueva petición limpia.</li>
            <li>Es un patrón muy habitual en formularios PHP: procesar → guardar → redirigir.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Flags de la cookie</h2>
        <ul>
            <li><code>httponly</code> evita acceso directo desde JavaScript.</li>
            <li><code>samesite=Lax</code> ayuda a reducir ciertos riesgos en peticiones cruzadas.</li>
            <li>En local usamos <code>secure => false</code> para que funcione en <code>http://localhost</code>.</li>
            <li>En producción con HTTPS, lo correcto sería usar <code>secure => true</code>.</li>
        </ul>
    </div>
</div>

</body>
</html>