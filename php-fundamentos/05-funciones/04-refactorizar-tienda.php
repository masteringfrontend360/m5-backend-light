<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Refactorizar tienda</title>

<style>

body{
    font-family: Arial;
    margin:40px;
    background:#f4f4f4;
}

.box{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:8px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.result{
    background:#eef;
    padding:15px;
    margin-top:15px;
    border-radius:8px;
}

.producto{
    background:white;
    border:1px solid #ddd;
    border-radius:8px;
    padding:20px;
    margin-bottom:15px;
}

.producto h3{
    margin-top:0;
    margin-bottom:12px;
    color:#333;
}

.lista-datos{
    margin:12px 0 0 0;
    padding-left:20px;
}

.tipo-principal{
    color:#155724;
    font-weight:bold;
}

.tipo-complemento{
    color:#856404;
    font-weight:bold;
}

.stock-disponible{
    color:#155724;
    font-weight:bold;
}

.stock-pocas{
    color:#856404;
    font-weight:bold;
}

.stock-agotado{
    color:#721c24;
    font-weight:bold;
}

.badge{
    display:inline-block;
    padding:6px 10px;
    border-radius:6px;
    font-size:14px;
    font-weight:bold;
    margin-right:8px;
    margin-bottom:8px;
}

.badge-principal{
    background:#d4edda;
    color:#155724;
}

.badge-complemento{
    background:#fff3cd;
    color:#856404;
}

.badge-preview{
    background:#d1ecf1;
    color:#0c5460;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
    margin-top:15px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-weight:bold;
    margin-bottom:6px;
    color:#333;
}

.form-help{
    font-size:14px;
    color:#666;
    margin-top:6px;
}

input, button{
    padding:10px;
    font-size:16px;
    border:1px solid #ccc;
    border-radius:6px;
}

button{
    grid-column:1 / -1;
    width:220px;
    background:#333;
    color:white;
    border:none;
    cursor:pointer;
}

button:hover{
    background:#555;
}

.codigo{
    background:#f7f7f7;
    border:1px solid #ddd;
    padding:10px;
    border-radius:6px;
    font-family: monospace;
    margin-top:10px;
}

.preview-tarjeta{
    margin-top:20px;
}

</style>

</head>

<body>

<?php

$productos = [
    ['nombre' => 'Camiseta', 'precio' => 20, 'stock' => 12],
    ['nombre' => 'Taza', 'precio' => 8.5, 'stock' => 2],
    ['nombre' => 'Pegatina', 'precio' => 2.25, 'stock' => 0],
];

function formatear_precio(float $precio): string {
    return number_format($precio, 2) . " €";
}

function obtener_mensaje_stock(int $stock): string {

    if ($stock > 10) {
        return "Disponible";
    }

    if ($stock > 0) {
        return "Quedan pocas unidades";
    }

    return "Agotado";
}

function obtener_clase_stock(int $stock): string {

    if ($stock > 10) {
        return "stock-disponible";
    }

    if ($stock > 0) {
        return "stock-pocas";
    }

    return "stock-agotado";
}

function obtener_tipo_producto(float $precio): string {

    if ($precio > 10) {
        return "Producto principal";
    }

    return "Producto complemento";
}

function obtener_clase_tipo(float $precio): string {

    if ($precio > 10) {
        return "tipo-principal";
    }

    return "tipo-complemento";
}

function obtener_badge_tipo(float $precio): string {

    if ($precio > 10) {
        return "<span class='badge badge-principal'>Producto principal</span>";
    }

    return "<span class='badge badge-complemento'>Producto complemento</span>";
}

function renderizar_producto(array $producto): string {

    $precioFormateado = formatear_precio($producto['precio']);
    $mensajeStock = obtener_mensaje_stock($producto['stock']);
    $claseStock = obtener_clase_stock($producto['stock']);
    $tipoProducto = obtener_tipo_producto($producto['precio']);
    $claseTipo = obtener_clase_tipo($producto['precio']);
    $badgeTipo = obtener_badge_tipo($producto['precio']);

    return "
        <article class='producto'>
            <h3>{$producto['nombre']}</h3>

            $badgeTipo

            <ul class='lista-datos'>
                <li><b>Nombre:</b> {$producto['nombre']}</li>
                <li><b>Precio original:</b> {$producto['precio']}</li>
                <li><b>Precio formateado:</b> $precioFormateado</li>
                <li><b>Stock real:</b> {$producto['stock']} unidades</li>
                <li><b>Mensaje de stock:</b> <span class='$claseStock'>$mensajeStock</span></li>
                <li><b>Tipo de producto:</b> <span class='$claseTipo'>$tipoProducto</span></li>
            </ul>
        </article>
    ";
}

function renderizar_tienda(array $productos): string {

    $html = "";

    foreach ($productos as $producto) {
        $html .= renderizar_producto($producto);
    }

    return $html;
}

$nombreTest = null;
$precioTest = null;
$stockTest = null;
$mensajeStockTest = null;
$claseStockTest = null;
$tipoProductoTest = null;
$claseTipoTest = null;
$productoTest = null;
$resultadoProductoTest = "";

if (
    isset($_POST['nombre_test']) &&
    isset($_POST['precio_test']) &&
    isset($_POST['stock_test'])
) {
    $nombreTest = trim($_POST['nombre_test']);
    $precioTest = (float) $_POST['precio_test'];
    $stockTest = (int) $_POST['stock_test'];

    $productoTest = [
        'nombre' => $nombreTest,
        'precio' => $precioTest,
        'stock' => $stockTest,
    ];

    $mensajeStockTest = obtener_mensaje_stock($stockTest);
    $claseStockTest = obtener_clase_stock($stockTest);
    $tipoProductoTest = obtener_tipo_producto($precioTest);
    $claseTipoTest = obtener_clase_tipo($precioTest);
    $resultadoProductoTest = renderizar_producto($productoTest);
}

?>

<div class="box">

<h2>Probar producto refactorizado</h2>

<form method="post" class="form-grid">

    <div class="form-group">
        <label for="nombre_test">Nombre del producto</label>
        <input
            type="text"
            name="nombre_test"
            id="nombre_test"
            value="<?php echo isset($_POST['nombre_test']) ? htmlspecialchars($_POST['nombre_test']) : ''; ?>"
        >
        <div class="form-help">Ejemplo: Taza premium</div>
    </div>

    <div class="form-group">
        <label for="precio_test">Precio</label>
        <input
            type="number"
            step="0.01"
            name="precio_test"
            id="precio_test"
            min="0"
            value="<?php echo isset($_POST['precio_test']) ? htmlspecialchars($_POST['precio_test']) : ''; ?>"
        >
        <div class="form-help">Más de 10 = producto principal</div>
    </div>

    <div class="form-group">
        <label for="stock_test">Unidades en stock</label>
        <input
            type="number"
            name="stock_test"
            id="stock_test"
            min="0"
            value="<?php echo isset($_POST['stock_test']) ? htmlspecialchars($_POST['stock_test']) : ''; ?>"
        >
        <div class="form-help">Sirve para calcular el mensaje de stock</div>
    </div>

    <button type="submit">Comprobar</button>

</form>

<?php if ($nombreTest !== null): ?>

<div class="result">

    <p>
        <span class="badge badge-preview">Vista previa del producto refactorizado</span>
    </p>

    <p>
        <b>Nombre:</b> <?php echo htmlspecialchars($nombreTest); ?><br><br>
        <b>Precio formateado:</b> <?php echo formatear_precio($precioTest); ?><br><br>
        <b>Mensaje de stock:</b> <span class="<?php echo $claseStockTest; ?>"><?php echo $mensajeStockTest; ?></span><br><br>
        <b>Tipo de producto:</b> <span class="<?php echo $claseTipoTest; ?>"><?php echo $tipoProductoTest; ?></span>
    </p>

    <div class="preview-tarjeta">
        <?php echo $resultadoProductoTest; ?>
    </div>

</div>

<?php endif; ?>

<p>

<b>Explicación:</b><br><br>

Aquí puedes probar manualmente cómo responden las funciones según los datos del producto.<br><br>

- <b>formatear_precio()</b> da formato al precio<br>
- <b>obtener_mensaje_stock()</b> calcula el texto del stock<br>
- <b>obtener_tipo_producto()</b> decide si es principal o complemento<br>
- <b>renderizar_producto()</b> junta toda la información en una sola ficha<br><br>

La idea del ejercicio es ver cómo una lógica que antes estaba mezclada dentro del <b>foreach</b> ahora queda mucho más limpia y ordenada.

</p>

</div>



<div class="box">

<h2>Tienda refactorizada</h2>

<div class="result">

<?php echo renderizar_tienda($productos); ?>

</div>

<p>

<b>Explicación:</b><br><br>

Este ejercicio parte de un código inicial que funcionaba, pero mezclaba demasiada lógica directamente dentro del bucle.<br><br>

<b>Proceso tras refactorizar:</b><br><br>

1. Se recorre el array de productos.<br>
2. <b>formatear_precio()</b> prepara el precio para mostrarlo.<br>
3. <b>obtener_mensaje_stock()</b> calcula el estado del stock.<br>
4. <b>obtener_tipo_producto()</b> clasifica el producto según el precio.<br>
5. <b>renderizar_producto()</b> devuelve todo el HTML de cada ficha.<br>
6. El <b>foreach</b> principal queda limpio porque solo se centra en renderizar.<br><br>

Así se entiende mejor por qué las funciones ayudan tanto a escribir código más legible y mantenible.

</p>

<div class="codigo">
array productos → funciones pequeñas → renderizar_producto() → tienda más limpia
</div>

</div>

</body>
</html>