<?php
ob_start();
session_start();

$bloque1Texto = '';
$bloque2Texto = '';
$bloque3Texto = '';
$cookieDemoActual = $_COOKIE['demo_buffer'] ?? 'No existe todavía';

// Bloque 1: explicación didáctica del error clásico
$bloque1Texto = "Si haces echo antes de session_start() o setcookie(), PHP puede lanzar el error 'headers already sent'. En este archivo no rompemos nada porque activamos ob_start() al principio y usamos el ejemplo de forma segura.";

// Bloque 2: simulación correcta con buffer
$nombreSesion = session_name();
$idSesion = session_id();
$bloque2Texto = "Con output buffering, PHP puede retener la salida temporalmente. Así, aunque haya contenido preparado, todavía puede enviar cabeceras como la de sesión. Sesión actual: {$nombreSesion} / ID: {$idSesion}.";

// Bloque 3: cookie + redirect a la misma página
if (isset($_POST['crear_cookie_demo'])) {
    setcookie(
        'demo_buffer',
        'Cookie creada con output buffering',
        [
            'expires' => time() + 3600,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );

    $_SESSION['flash_buffer'] = [
        'tipo' => 'ok',
        'mensaje' => 'Cookie de demostración creada correctamente y redirección realizada sin error de cabeceras.',
    ];

    header('Location: debug-headers.php');
    exit;
}

if (isset($_POST['borrar_cookie_demo'])) {
    setcookie(
        'demo_buffer',
        '',
        [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );

    $_SESSION['flash_buffer'] = [
        'tipo' => 'ok',
        'mensaje' => 'Cookie de demostración eliminada correctamente.',
    ];

    header('Location: debug-headers.php');
    exit;
}

$flash = $_SESSION['flash_buffer'] ?? null;
unset($_SESSION['flash_buffer']);

$cookieDemoActual = $_COOKIE['demo_buffer'] ?? 'No existe todavía';
$bloque3Texto = "En este bloque usamos setcookie() + header('Location: ...') para redirigir a la misma página después de guardar la cookie. Gracias al buffer de salida, evitamos problemas de cabeceras y además conseguimos una petición limpia tras el POST.";

$sessionInfo = [
    'session_name()' => session_name(),
    'session_id()' => session_id(),
    'session_status()' => session_status(),
    'session.cookie_httponly' => ini_get('session.cookie_httponly'),
    'session.cookie_secure' => ini_get('session.cookie_secure'),
    'session.use_cookies' => ini_get('session.use_cookies'),
    'session.use_only_cookies' => ini_get('session.use_only_cookies'),
    'session.save_path' => ini_get('session.save_path'),
    'session.gc_maxlifetime' => ini_get('session.gc_maxlifetime'),
];

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 04 · Output Buffering</title>
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

        .warning {
            background: #fff8e5;
            border-left: 4px solid #dba617;
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .bloque {
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

        .boton-secundario {
            background: #50575e;
        }

        .boton-secundario:hover {
            background: #3c434a;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .tabla-info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            background: #ffffff;
        }

        .tabla-info th,
        .tabla-info td {
            border: 1px solid #dcdcde;
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }

        .tabla-info th {
            background: #f6f7f7;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        ul {
            padding-left: 20px;
        }

        .estado-cookie {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Ejercicio 04 · Output Buffering y cabeceras</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> entender por qué aparece el error <code>headers already sent</code> y cómo ayuda <code>ob_start()</code>.</p>
        <p>En PHP, funciones como <code>session_start()</code>, <code>setcookie()</code> o <code>header()</code> trabajan con cabeceras HTTP. Si ya se ha enviado salida al navegador antes de tiempo, esas cabeceras pueden fallar.</p>
        <p>Con <code>ob_start()</code> activamos un buffer de salida: PHP guarda temporalmente el contenido y eso da margen para enviar cabeceras antes de vaciar la salida final.</p>
    </div>

    <?php if ($flash): ?>
        <div class="<?php echo htmlspecialchars($flash['tipo']); ?>">
            <?php echo htmlspecialchars($flash['mensaje']); ?>
        </div>
    <?php endif; ?>

    <div class="bloque">
        <h2>Bloque 1 · El error clásico</h2>
        <div class="warning">
            <?php echo htmlspecialchars($bloque1Texto); ?>
        </div>

        <p><strong>Ejemplo problemático típico:</strong></p>
        <pre><code>&lt;?php
echo "Hola";
session_start(); // Esto puede fallar si ya salió contenido
</code></pre>

        <p>La idea importante es esta: <strong>primero cabeceras, luego salida</strong>. Si inviertes el orden, puedes romper la petición.</p>
    </div>

    <div class="bloque">
        <h2>Bloque 2 · Solución con ob_start()</h2>
        <p><?php echo htmlspecialchars($bloque2Texto); ?></p>

        <pre><code>&lt;?php
ob_start();
echo "Hola";
session_start(); // Mucho más seguro con buffer activo
</code></pre>

        <p>Aquí no estamos diciendo que siempre haya que abusar de <code>ob_start()</code>, pero sí que es una herramienta muy útil cuando trabajas con sesiones, cookies, includes y redirecciones en prácticas PHP.</p>
    </div>

    <div class="bloque">
        <h2>Bloque 3 · Cookie + redirect</h2>
        <p><?php echo htmlspecialchars($bloque3Texto); ?></p>

        <p class="estado-cookie">
            Estado actual de la cookie demo:
            <?php echo htmlspecialchars($cookieDemoActual); ?>
        </p>

        <form method="POST" action="">
            <div class="acciones">
                <button type="submit" name="crear_cookie_demo" value="1">Crear cookie demo</button>
                <button type="submit" name="borrar_cookie_demo" value="1" class="boton-secundario">Borrar cookie demo</button>
                <a class="boton-enlace" href="../01-login-sesion/index.php">Volver al panel</a>
            </div>
        </form>
    </div>

    <div class="mini-box">
        <h2>Qué aprender con este ejercicio</h2>
        <ul>
            <li>Qué significa realmente <code>headers already sent</code>.</li>
            <li>Por qué sesiones, cookies y redirecciones dependen de las cabeceras HTTP.</li>
            <li>Cómo usar <code>ob_start()</code> para controlar mejor la salida.</li>
            <li>Cómo aplicar un flujo limpio de <code>POST → setcookie/header → redirect</code>.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Información de sesión del entorno</h2>
        <p>En vez de usar <code>phpinfo(INFO_SESSION)</code>, aquí mostramos los datos de sesión de forma controlada y compatible.</p>

        <table class="tabla-info">
            <thead>
                <tr>
                    <th>Propiedad</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessionInfo as $clave => $valor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string) $clave); ?></td>
                        <td><?php echo htmlspecialchars((string) $valor); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>