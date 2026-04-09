<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Productos destacados</title>

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

.badge{
    display:inline-block;
    padding:6px 10px;
    border-radius:6px;
    font-size:14px;
    font-weight:bold;
    margin-right:8px;
    margin-bottom:8px;
}

.badge-destacado{
    background:#d1ecf1;
    color:#0c5460;
}

.badge-visible{
    background:#d4edda;
    color:#155724;
}

.badge-no-visible{
    background:#f8d7da;
    color:#721c24;
}

.stock-disponible{
    color:#155724;
    font-weight:bold;
}

.stock-ultimas{
    color:#856404;
    font-weight:bold;
}

.stock-agotado{
    color:#721c24;
    font-weight:bold;
}

.lista-datos{
    margin:12px 0 0 0;
    padding-left:20px;
}

.codigo{
    background:#f7f7f7;
    border:1px solid #ddd;
    padding:10px;
    border-radius:6px;
    font-family: monospace;
    margin-top:10px;
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

input, button, select{
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

.resumen-prueba{
    margin-top:12px;
    line-height:1.8;
}

.listado{
    margin-top:10px;
}

.vacio{
    background:#fff3cd;
    color:#856404;
    padding:12px;
    border-radius:8px;
    font-weight:bold;
}

.preview-tarjeta{
    margin-top:20px;
}

</style>

</head>

<body>

<?php

$productos = [
    ['nombre' => 'Plugin SEO', 'precio' => 29.99, 'destacado' => true, 'stock' => 12],
    ['nombre' => 'Tema corporativo', 'precio' => 59.00, 'destacado' => false, 'stock' => 4],
    ['nombre' => 'Pack formularios', 'precio' => 18.50, 'destacado' => true, 'stock' => 0],
    ['nombre' => 'Módulo reservas', 'precio' => 80.00, 'destacado' => true, 'stock' => 7],
];

function formatear_precio(float $precio): string {
    return number_format($precio, 2) . " €";
}

function es_producto_visible(array $producto): bool {
    return $producto['destacado'] === true;
}

function generar_etiqueta_stock(int $stock): string {

    if ($stock >= 10) {
        return "Disponible";
    }

    if ($stock > 0) {
        return "Últimas unidades";
    }

    return "Agotado";
}

function obtener_clase_stock(int $stock): string {

    if ($stock >= 10) {
        return "stock-disponible";
    }

    if ($stock > 0) {
        return "stock-ultimas";
    }

    return "stock-agotado";
}

function renderizar_tarjeta_destacada(array $producto): string {

    $precioFormateado = formatear_precio($producto['precio']);
    $etiquetaStock = generar_etiqueta_stock($producto['stock']);
    $claseStock = obtener_clase_stock($producto['stock']);

    return "
        <article class='producto'>
            <h3>{$producto['nombre']}</h3>

            <span class='badge badge-destacado'>Producto destacado</span>

            <ul class='lista-datos'>
                <li><b>Nombre:</b> {$producto['nombre']}</li>
                <li><b>Precio original:</b> {$producto['precio']}</li>
                <li><b>Precio formateado:</b> $precioFormateado</li>
                <li><b>Stock real:</b> {$producto['stock']} unidades</li>
                <li><b>Etiqueta de stock:</b> <span class='$claseStock'>$etiquetaStock</span></li>
                <li><b>Visible en destacados:</b> Sí</li>
            </ul>
        </article>
    ";
}

function renderizar_listado_destacados(array $productos): string {

    $html = "<div class='listado'>";

    foreach ($productos as $producto) {
        if (!es_producto_visible($producto)) {
            continue;
        }

        $html .= renderizar_tarjeta_destacada($producto);
    }

    $html .= "</div>";

    return $html;
}

$nombreTest = null;
$precioTest = null;
$destacadoTest = null;
$stockTest = null;
$visibleTest = null;
$etiquetaStockTest = null;
$claseStockTest = null;
$productoTest = null;
$resultadoTarjetaTest = "";
$badgeVisibilidad = "";

if (
    isset($_POST['nombre_test']) &&
    isset($_POST['precio_test']) &&
    isset($_POST['destacado_test']) &&
    isset($_POST['stock_test'])
) {
    $nombreTest = trim($_POST['nombre_test']);
    $precioTest = (float) $_POST['precio_test'];
    $destacadoTest = $_POST['destacado_test'] === '1';
    $stockTest = (int) $_POST['stock_test'];

    $productoTest = [
        'nombre' => $nombreTest,
        'precio' => $precioTest,
        'destacado' => $destacadoTest,
        'stock' => $stockTest,
    ];

    $visibleTest = es_producto_visible($productoTest);
    $etiquetaStockTest = generar_etiqueta_stock($stockTest);
    $claseStockTest = obtener_clase_stock($stockTest);

    if ($visibleTest) {
        $resultadoTarjetaTest = renderizar_tarjeta_destacada($productoTest);
        $badgeVisibilidad = "<span class='badge badge-visible'>Sí se mostraría en destacados</span>";
    } else {
        $badgeVisibilidad = "<span class='badge badge-no-visible'>No se mostraría en destacados</span>";
    }
}

?>

<div class="box">

<h2>Probar producto destacado</h2>

<form method="post" class="form-grid">

    <div class="form-group">
        <label for="nombre_test">Nombre del producto</label>
        <input
            type="text"
            name="nombre_test"
            id="nombre_test"
            value="<?php echo isset($_POST['nombre_test']) ? htmlspecialchars($_POST['nombre_test']) : ''; ?>"
        >
        <div class="form-help">Ejemplo: Plugin SEO Pro</div>
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
        <div class="form-help">Ejemplo: 29.99</div>
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
        <div class="form-help">Sirve para calcular la etiqueta de stock</div>
    </div>

    <div class="form-group">
        <label for="destacado_test">¿Es destacado?</label>
        <select name="destacado_test" id="destacado_test">
            <option value="1" <?php echo (isset($_POST['destacado_test']) && $_POST['destacado_test'] === '1') ? 'selected' : ''; ?>>Sí</option>
            <option value="0" <?php echo (isset($_POST['destacado_test']) && $_POST['destacado_test'] === '0') ? 'selected' : ''; ?>>No</option>
        </select>
        <div class="form-help">Decide si el producto aparece o no en el listado</div>
    </div>

    <button type="submit">Comprobar</button>

</form>

<?php if ($nombreTest !== null): ?>

<div class="result">

    <div class="resumen-prueba">
        <b>Nombre:</b> <?php echo htmlspecialchars($nombreTest); ?><br><br>
        <b>Precio formateado:</b> <?php echo formatear_precio($precioTest); ?><br><br>
        <b>Stock introducido:</b> <?php echo $stockTest; ?><br><br>
        <b>Etiqueta de stock:</b> <span class="<?php echo $claseStockTest; ?>"><?php echo $etiquetaStockTest; ?></span><br><br>
        <b>¿Es destacado?:</b> <?php echo $destacadoTest ? 'Sí' : 'No'; ?><br><br>
        <?php echo $badgeVisibilidad; ?>
    </div>

    <?php if ($visibleTest): ?>
        <div class="preview-tarjeta">
            <?php echo $resultadoTarjetaTest; ?>
        </div>
    <?php endif; ?>

</div>

<?php endif; ?>

<p>

<b>Explicación:</b><br><br>

Aquí puedes probar manualmente cómo responden las funciones según los datos del producto.<br><br>

- <b>es_producto_visible()</b> decide si el producto se pinta o no<br>
- <b>generar_etiqueta_stock()</b> genera el texto breve del stock<br>
- <b>renderizar_tarjeta_destacada()</b> crea la tarjeta HTML del producto<br>
- <b>renderizar_listado_destacados()</b> recorre todos los productos y monta el bloque final<br><br>

Así se ve claramente que no todos los productos del array tienen por qué mostrarse.

</p>

</div>



<div class="box">

<h2>Mini listado de productos destacados</h2>

<div class="result">

<?php echo renderizar_listado_destacados($productos); ?>

</div>

<p>

<b>Explicación:</b><br><br>

Este ejercicio enseña cómo separar tres tareas muy habituales al trabajar con arrays de productos.<br><br>

<b>Proceso del listado:</b><br><br>

1. Se recorre el array completo de productos.<br>
2. <b>es_producto_visible()</b> filtra cuáles deben mostrarse.<br>
3. <b>generar_etiqueta_stock()</b> calcula el mensaje breve del stock.<br>
4. <b>renderizar_tarjeta_destacada()</b> construye cada tarjeta individual.<br>
5. <b>renderizar_listado_destacados()</b> junta todas las tarjetas visibles en un único bloque.<br><br>

Así se entiende mejor la diferencia entre <b>filtrar</b>, <b>transformar</b> y <b>renderizar</b>.

</p>

<div class="codigo">
array productos → filtro de destacados → etiqueta de stock → tarjetas renderizadas
</div>

</div>

</body>
</html>