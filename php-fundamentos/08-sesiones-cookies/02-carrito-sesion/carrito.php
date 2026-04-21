<?php
ob_start();
session_start();

// Protegemos la página: solo puede entrar un usuario con sesión activa
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    $_SESSION['flash'] = [
        'tipo' => 'error',
        'mensaje' => 'Debes iniciar sesión para acceder al carrito.',
    ];

    header('Location: ../01-login-sesion/login.php');
    exit;
}

// Inicializamos el carrito si todavía no existe
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$errores = [];
$mensajeOk = null;

// Vaciar carrito
if (isset($_POST['accion']) && $_POST['accion'] === 'vaciar') {
    unset($_SESSION['carrito']);
    $_SESSION['carrito'] = [];
    $mensajeOk = 'El carrito se ha vaciado correctamente.';
}

// Añadir producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'agregar') {
    $nombre = trim($_POST['nombre'] ?? '');
    $cantidad = (int) ($_POST['cantidad'] ?? 0);

    if ($nombre === '') {
        $errores[] = 'Debes escribir el nombre del producto.';
    }

    if (strlen($nombre) < 2 || strlen($nombre) > 100) {
        $errores[] = 'El nombre del producto debe tener entre 2 y 100 caracteres.';
    }

    if ($cantidad <= 0) {
        $errores[] = 'La cantidad debe ser mayor que 0.';
    }

    if (empty($errores)) {
        $_SESSION['carrito'][] = [
            'nombre' => $nombre,
            'cantidad' => $cantidad,
        ];

        $mensajeOk = 'Producto añadido correctamente al carrito.';
    }
}

$carrito = $_SESSION['carrito'];
$totalLineas = count($carrito);
$totalUnidades = 0;

foreach ($carrito as $producto) {
    $totalUnidades += $producto['cantidad'];
}

$nombresProductos = [];

foreach ($carrito as $producto) {
    $nombresProductos[] = $producto['nombre'];
}

$listaResumen = !empty($nombresProductos) ? implode(', ', $nombresProductos) : 'Todavía no hay productos.';

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 02 · Carrito con sesión</title>
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

        .carrito-box {
            background: #f9f9f9;
            border-left: 4px solid #72aee6;
            padding: 16px 18px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .item {
            background: #ffffff;
            border: 1px solid #dcdcde;
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 12px;
        }

        ul {
            padding-left: 20px;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .resumen {
            font-size: 15px;
            color: #50575e;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Ejercicio 02 · Carrito con sesión</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> guardar productos temporalmente en <code>$_SESSION</code> como si fuera un carrito simple.</p>
        <p>Este ejercicio sirve para entender que una sesión puede almacenar datos del usuario entre distintas peticiones, no solo el login.</p>
        <p>Aquí practicamos <code>session_start()</code>, arrays en sesión, <code>count()</code>, <code>implode()</code>, <code>unset()</code> y <code>ob_start()</code> para evitar problemas de cabeceras.</p>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="error">
            <strong>Hay errores en el formulario:</strong>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($mensajeOk): ?>
        <div class="ok">
            <?php echo htmlspecialchars($mensajeOk); ?>
        </div>
    <?php endif; ?>

    <h2>Añadir producto al carrito</h2>

    <form method="POST" action="">
        <input type="hidden" name="accion" value="agregar">

        <div class="campo">
            <label for="nombre">Nombre del producto</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
            <span class="hint">Ejemplo: Libro PHP, Curso JS, Ratón inalámbrico...</span>
        </div>

        <div class="campo">
            <label for="cantidad">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad" min="1" value="<?php echo htmlspecialchars($_POST['cantidad'] ?? '1'); ?>">
            <span class="hint">La cantidad debe ser mayor que 0.</span>
        </div>

        <div class="acciones">
            <button type="submit">Añadir al carrito</button>
        </div>
    </form>

    <div class="carrito-box">
        <h2>Estado actual del carrito</h2>

        <p><strong>Líneas del carrito:</strong> <?php echo htmlspecialchars((string) $totalLineas); ?></p>
        <p><strong>Total de unidades:</strong> <?php echo htmlspecialchars((string) $totalUnidades); ?></p>
        <p class="resumen"><strong>Resumen con implode():</strong> <?php echo htmlspecialchars($listaResumen); ?></p>

        <?php if (empty($carrito)): ?>
            <div class="item">
                El carrito está vacío.
            </div>
        <?php else: ?>
            <?php foreach ($carrito as $indice => $producto): ?>
                <div class="item">
                    <strong>Producto <?php echo htmlspecialchars((string) ($indice + 1)); ?>:</strong>
                    <?php echo htmlspecialchars($producto['nombre']); ?>
                    <br>
                    <strong>Cantidad:</strong> <?php echo htmlspecialchars((string) $producto['cantidad']); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <form method="POST" action="" style="margin-top: 16px;">
            <input type="hidden" name="accion" value="vaciar">
            <div class="acciones">
                <button type="submit" class="boton-secundario">Vaciar carrito</button>
                <a class="boton-enlace" href="../01-login-sesion/index.php">Volver al panel</a>
            </div>
        </form>
    </div>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>Protegemos la página comprobando si el usuario está logueado.</li>
            <li>Guardamos el carrito en <code>$_SESSION['carrito']</code>.</li>
            <li>Cada producto se añade como un pequeño array con nombre y cantidad.</li>
            <li>Contamos productos con <code>count()</code>.</li>
            <li>Construimos un resumen textual con <code>implode()</code>.</li>
            <li>Vaciamos el carrito con <code>unset()</code>.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Por qué usamos ob_start()</h2>
        <ul>
            <li><code>ob_start()</code> activa el buffer de salida.</li>
            <li>Eso ayuda a evitar errores tipo <code>headers already sent</code> si hacemos redirecciones o gestionamos cabeceras.</li>
            <li>En este ejercicio se incluye para practicar la idea que aparece en el README del tema.</li>
        </ul>
    </div>
</div>

</body>
</html>