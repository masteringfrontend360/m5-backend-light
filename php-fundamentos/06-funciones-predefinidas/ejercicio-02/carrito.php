<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Crear carrito en sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [
        [
            'nombre' => 'Camiseta',
            'precio' => 19.95,
            'cantidad' => 1
        ],
        [
            'nombre' => 'Pantalón',
            'precio' => 39.50,
            'cantidad' => 1
        ]
    ];
}

$carrito = &$_SESSION['carrito'];

$accion = $_GET['accion'] ?? 'ver';
$producto = trim($_GET['producto'] ?? '');
$precio = $_GET['precio'] ?? '';

$mensaje = '';
$error = '';

// Procesar acción
if ($accion === 'anadir') {
    if ($producto === '') {
        $error = 'No se puede añadir un producto sin nombre.';
    } elseif (filter_var($precio, FILTER_VALIDATE_FLOAT) === false) {
        $error = 'El precio indicado no es válido.';
    } else {
        $productoLimpio = htmlspecialchars($producto, ENT_QUOTES, 'UTF-8');
        $precioLimpio = (float) $precio;

        $productoEncontrado = false;

        foreach ($carrito as &$item) {
            if ($item['nombre'] === $productoLimpio) {
                $item['cantidad']++;
                $productoEncontrado = true;
                $mensaje = 'El producto ya existía en el carrito y se ha aumentado su cantidad.';
                break;
            }
        }
        unset($item);

        if (!$productoEncontrado) {
            $nuevoProducto = [
                'nombre' => $productoLimpio,
                'precio' => $precioLimpio,
                'cantidad' => 1
            ];

            array_push($carrito, $nuevoProducto);
            $mensaje = 'Producto añadido correctamente al carrito.';
        }
    }
} elseif ($accion === 'quitar') {
    if (count($carrito) > 0) {
        $ultimoIndice = count($carrito) - 1;

        if ($carrito[$ultimoIndice]['cantidad'] > 1) {
            $carrito[$ultimoIndice]['cantidad']--;
            $mensaje = 'Se ha reducido en 1 la cantidad del último producto del carrito.';
        } else {
            $productoQuitado = array_pop($carrito);
            $mensaje = 'Se ha quitado el último producto del carrito: ' . $productoQuitado['nombre'] . '.';
        }
    } else {
        $error = 'No hay productos en el carrito para quitar.';
    }
} elseif ($accion === 'vaciar') {
    $carrito = [];
    $mensaje = 'El carrito se ha vaciado correctamente.';
} elseif ($accion === 'ver') {
    $mensaje = 'Mostrando carrito actual.';
} else {
    $error = 'La acción indicada no es válida. Usa ver, anadir, quitar o vaciar.';
}

// Calcular total de unidades
$totalUnidades = array_reduce(
    $carrito,
    function ($acumulado, $item) {
        return $acumulado + $item['cantidad'];
    },
    0
);

// Calcular total económico
$total = array_reduce(
    $carrito,
    function ($acumulado, $item) {
        return $acumulado + ($item['precio'] * $item['cantidad']);
    },
    0
);

$totalProductosDistintos = count($carrito);

// Preparar línea resumen con implode()
$resumenProductos = [];

foreach ($carrito as $item) {
    $subtotal = $item['precio'] * $item['cantidad'];

    $resumenProductos[] =
        $item['nombre']
        . ' x' . $item['cantidad']
        . ' (€' . number_format($item['precio'], 2, ',', '.') . ')'
        . ' = €' . number_format($subtotal, 2, ',', '.');
}

$listaFinal = empty($resumenProductos) ? 'El carrito está vacío.' : implode(' | ', $resumenProductos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito WooCommerce dinámico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
            color: #333;
        }

        .box {
            background: white;
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

        .ok {
            background: #edfaef;
            border-left: 4px solid #00a32a;
            padding: 12px 16px;
            margin-bottom: 14px;
            border-radius: 6px;
        }

        .error {
            background: #fff1f1;
            border-left: 4px solid #d63638;
            padding: 12px 16px;
            margin-bottom: 14px;
            border-radius: 6px;
        }

        .carrito-box {
            background: #f9f9f9;
            border-left: 4px solid #7e8993;
            padding: 16px;
            border-radius: 6px;
            margin: 18px 0;
        }

        .carrito-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .carrito-box li {
            margin-bottom: 12px;
        }

        .meta-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 16px;
        }

        .total-box {
            background: #fff8e5;
            border-left: 4px solid #dba617;
            padding: 16px;
            border-radius: 6px;
            margin-top: 16px;
            font-size: 20px;
            font-weight: bold;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .acciones a {
            display: inline-block;
            text-decoration: none;
            background: #0073aa;
            color: white;
            padding: 10px 14px;
            border-radius: 6px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .acciones a:hover {
            background: #005f8d;
        }

        .acciones .danger {
            background: #d63638;
        }

        .acciones .danger:hover {
            background: #b32d2e;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        ul {
            padding-left: 20px;
        }

        .resumen-linea {
            background: #eef4ff;
            border-left: 4px solid #2271b1;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 18px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Ejercicio 02 · Carrito WooCommerce dinámico</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> simular un carrito básico de WooCommerce usando arrays, funciones predefinidas y persistencia con sesión.</p>
        <p>En este ejercicio se trabajan <code>count()</code>, <code>array_push()</code>, <code>array_pop()</code>, <code>implode()</code>, <code>number_format()</code>, <code>array_reduce()</code>, <code>filter_var()</code> y <code>$_SESSION</code>.</p>
    </div>

    <?php if ($mensaje !== ''): ?>
        <div class="ok"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <h2>Vista del carrito</h2>

    <div class="carrito-box">
        <p><strong>Productos distintos:</strong> <?php echo $totalProductosDistintos; ?></p>
        <p><strong>Unidades totales:</strong> <?php echo $totalUnidades; ?></p>

        <?php if ($totalProductosDistintos === 0): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($carrito as $item): ?>
                    <li>
                        <strong><?php echo $item['nombre']; ?></strong><br>
                        Cantidad: <?php echo $item['cantidad']; ?><br>
                        Precio unitario: €<?php echo number_format($item['precio'], 2, ',', '.'); ?><br>
                        Subtotal: €<?php echo number_format($item['precio'] * $item['cantidad'], 2, ',', '.'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="resumen-linea">
        <strong>Resumen en una línea:</strong><br>
        <?php echo $listaFinal; ?>
    </div>

    <div class="total-box">
        TOTAL: €<?php echo number_format($total, 2, ',', '.'); ?>
    </div>

    <div class="mini-box">
        <h2>Acciones de prueba</h2>
        <div class="acciones">
            <a href="?accion=ver">Ver carrito</a>
            <a href="?accion=anadir&producto=Calcetines&precio=12.50">Añadir Calcetines</a>
            <a href="?accion=anadir&producto=Sudadera&precio=49.99">Añadir Sudadera</a>
            <a href="?accion=anadir&producto=Camiseta&precio=19.95">Añadir otra Camiseta</a>
            <a href="?accion=quitar">Quitar último producto</a>
            <a href="?accion=anadir&producto=ProductoSinPrecio&precio=abc">Probar precio inválido</a>
            <a class="danger" href="?accion=vaciar">Vaciar carrito</a>
        </div>
    </div>

    <div class="mini-box">
        <h2>Resumen didáctico</h2>
        <ul>
            <li><code>count()</code> cuenta cuántos productos distintos hay en el carrito.</li>
            <li><code>array_push()</code> añade un producto nuevo al array si no existía antes.</li>
            <li><code>array_pop()</code> elimina el último producto si su cantidad llega a 1.</li>
            <li><code>implode()</code> construye una línea resumen con todos los productos.</li>
            <li><code>number_format()</code> muestra precios con formato europeo.</li>
            <li><code>array_reduce()</code> suma unidades y también calcula el total económico.</li>
            <li><code>filter_var()</code> valida que el precio recibido sea numérico.</li>
            <li><code>$_SESSION</code> hace que el carrito mantenga su estado entre recargas.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>URLs útiles</h2>
        <p>
            <code>?accion=ver</code><br>
            <code>?accion=anadir&producto=Calcetines&precio=12.50</code><br>
            <code>?accion=anadir&producto=Sudadera&precio=49.99</code><br>
            <code>?accion=quitar</code><br>
            <code>?accion=vaciar</code>
        </p>
    </div>
</div>

</body>
</html>