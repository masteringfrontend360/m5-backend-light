<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Procesador de productos</title>

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
    margin-top:10px;
}

.producto{
    background:white;
    border:1px solid #ddd;
    border-radius:8px;
    padding:15px;
    margin-bottom:15px;
}

.producto h3{
    margin-top:0;
    margin-bottom:12px;
}

.lista-datos{
    margin:0;
    padding-left:20px;
}

.stock-ok{
    color:green;
    font-weight:bold;
}

.stock-bajo{
    color:orange;
    font-weight:bold;
}

.stock-agotado{
    color:red;
    font-weight:bold;
}

.etiqueta{
    display:inline-block;
    padding:4px 8px;
    border-radius:6px;
    font-size:14px;
    font-weight:bold;
    margin-top:5px;
}

.etiqueta-ok{
    background:#d4edda;
    color:#155724;
}

.etiqueta-bajo{
    background:#fff3cd;
    color:#856404;
}

.etiqueta-agotado{
    background:#f8d7da;
    color:#721c24;
}

input, button{
    padding:8px;
    font-size:16px;
    margin-top:8px;
}

.codigo{
    background:#f7f7f7;
    border:1px solid #ddd;
    padding:10px;
    border-radius:6px;
    font-family: monospace;
    margin-top:10px;
}

</style>

</head>

<body>

<?php

$productos = [
    [
        'nombre' => 'Camiseta WordPress',
        'precio' => 19.9,
        'stock' => 8,
        'categoria' => 'merchandising',
    ],
    [
        'nombre' => 'Taza WooCommerce',
        'precio' => 12.5,
        'stock' => 24,
        'categoria' => 'hogar',
    ],
    [
        'nombre' => 'Sudadera Gutenberg',
        'precio' => 39,
        'stock' => 3,
        'categoria' => 'ropa',
    ],
];

function formatear_precio(float $precio): string {
    return number_format($precio, 2) . " €";
}

function obtener_estado_stock(int $stock): string {

    if ($stock >= 10) {
        return "En stock";
    }

    if ($stock > 0) {
        return "Quedan pocas unidades";
    }

    return "Sin stock";
}

function obtener_clase_stock(int $stock): string {

    if ($stock >= 10) {
        return "stock-ok";
    }

    if ($stock > 0) {
        return "stock-bajo";
    }

    return "stock-agotado";
}

function obtener_etiqueta_stock(int $stock): string {

    if ($stock >= 10) {
        return "etiqueta etiqueta-ok";
    }

    if ($stock > 0) {
        return "etiqueta etiqueta-bajo";
    }

    return "etiqueta etiqueta-agotado";
}

function mostrar_producto(array $producto): string {

    $precioFormateado = formatear_precio($producto['precio']);
    $estadoStock = obtener_estado_stock($producto['stock']);
    $claseStock = obtener_clase_stock($producto['stock']);
    $etiquetaStock = obtener_etiqueta_stock($producto['stock']);

    return "
        <article class='producto'>
            <h3>{$producto['nombre']}</h3>

            <ul class='lista-datos'>
                <li><b>Nombre:</b> {$producto['nombre']}</li>
                <li><b>Categoría:</b> {$producto['categoria']}</li>
                <li><b>Precio original:</b> {$producto['precio']}</li>
                <li><b>Precio formateado:</b> $precioFormateado</li>
                <li><b>Unidades reales en stock:</b> {$producto['stock']}</li>
                <li><b>Estado calculado:</b> <span class='$claseStock'>$estadoStock</span></li>
                <li><b>Clase CSS calculada:</b> $claseStock</li>
            </ul>

            <p class='$etiquetaStock'>$estadoStock</p>
        </article>
    ";
}

?>

<div class="box">

<h2>Probar estado de stock</h2>

<form method="post">
    <label for="stock_test">Introduce unidades en stock:</label><br>
    <input type="number" name="stock_test" id="stock_test" min="0">
    <button type="submit">Comprobar</button>
</form>

<?php

if (isset($_POST['stock_test'])) {

    $stock = (int) $_POST['stock_test'];
    $estado = obtener_estado_stock($stock);
    $clase = obtener_clase_stock($stock);
    $etiqueta = obtener_etiqueta_stock($stock);

    echo '<div class="result">';
    echo "Unidades introducidas → $stock<br><br>";
    echo "Estado calculado → <span class='$clase'>$estado</span><br><br>";
    echo "Clase CSS devuelta → <b>$clase</b><br><br>";
    echo "<span class='$etiqueta'>$estado</span>";
    echo '</div>';
}

?>

<p>

<b>Explicación:</b><br><br>

Aquí probamos manualmente cómo responden las funciones según el stock.<br><br>

10 o más → En stock<br>
Entre 1 y 9 → Quedan pocas unidades<br>
0 → Sin stock

</p>

</div>



<div class="box">

<h2>Procesador de productos</h2>

<div class="result">

<?php

foreach ($productos as $producto) {
    echo mostrar_producto($producto);
}

?>

</div>

<p>

<b>Explicación:</b><br><br>

Este ejercicio quiere enseñar cómo un mismo dato pasa por varias funciones hasta generar el resultado final.<br><br>

<b>Proceso que sigue cada producto:</b><br><br>

1. Se lee el array del producto.<br>
2. <b>formatear_precio()</b> transforma el precio en un formato bonito.<br>
3. <b>obtener_estado_stock()</b> decide el mensaje según las unidades.<br>
4. <b>obtener_clase_stock()</b> decide la clase CSS adecuada.<br>
5. <b>obtener_etiqueta_stock()</b> prepara la etiqueta visual.<br>
6. <b>mostrar_producto()</b> junta todo y genera el HTML final.<br><br>

Así se entiende mejor qué significa “procesar” un producto:
no solo mostrarlo, sino <b>transformar sus datos</b> antes de pintarlo.

</p>

<div class="codigo">
array producto → funciones pequeñas → resultado visual
</div>

</div>

</body>
</html>