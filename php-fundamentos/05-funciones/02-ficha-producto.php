<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Ficha de producto</title>

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

.badge-descuento{
    background:#fff3cd;
    color:#856404;
}

.badge-envio{
    background:#d4edda;
    color:#155724;
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

.porcentaje-preview{
    display:inline-block;
    margin-top:8px;
    font-weight:bold;
    color:#856404;
    background:#fff3cd;
    border-radius:6px;
    padding:6px 10px;
    width:fit-content;
}

.precio-original{
    color:#666;
    text-decoration:line-through;
}

.precio-final{
    font-size:22px;
    font-weight:bold;
    color:#155724;
}

.fila-precios{
    margin-top:12px;
    margin-bottom:12px;
}

</style>

</head>

<body>

<?php

$producto = [
    'nombre' => 'Pack tienda online',
    'precio' => 49.95,
    'descuento' => 0.15,
    'stock' => 6,
    'envio_gratis' => true,
    'valoracion' => 4.6,
];

function formatear_precio(float $precio): string {
    return number_format($precio, 2) . " €";
}

function calcular_precio_rebajado(float $precio, float $descuento): float {
    return $precio - ($precio * $descuento);
}

function mostrar_badge_descuento(float $descuento): string {

    if ($descuento > 0) {
        $porcentaje = $descuento * 100;
        return "<span class='badge badge-descuento'>Descuento: -" . number_format($porcentaje, 0) . "%</span>";
    }

    return "";
}

function mostrar_badge_envio(bool $envioGratis): string {

    if ($envioGratis) {
        return "<span class='badge badge-envio'>Envío gratis</span>";
    }

    return "";
}

function formatear_valoracion(float $valoracion): string {
    return number_format($valoracion, 1) . " / 5";
}

function renderizar_ficha_producto(array $producto): string {

    $precioOriginal = formatear_precio($producto['precio']);
    $precioRebajado = formatear_precio(
        calcular_precio_rebajado($producto['precio'], $producto['descuento'])
    );

    $badgeDescuento = mostrar_badge_descuento($producto['descuento']);
    $badgeEnvio = mostrar_badge_envio($producto['envio_gratis']);
    $valoracion = formatear_valoracion($producto['valoracion']);
    $porcentajeDescuento = number_format($producto['descuento'] * 100, 0);

    return "
        <article class='producto'>
            <h3>{$producto['nombre']}</h3>

            $badgeDescuento
            $badgeEnvio

            <div class='fila-precios'>
                <p class='precio-original'>Precio original: $precioOriginal</p>
                <p class='precio-final'>Precio final: $precioRebajado</p>
            </div>

            <ul class='lista-datos'>
                <li><b>Descuento aplicado:</b> {$producto['descuento']} → {$porcentajeDescuento}%</li>
                <li><b>Stock disponible:</b> {$producto['stock']} unidades</li>
                <li><b>Envío gratis:</b> " . ($producto['envio_gratis'] ? 'Sí' : 'No') . "</li>
                <li><b>Valoración formateada:</b> $valoracion</li>
            </ul>
        </article>
    ";
}

$precioTest = null;
$descuentoTest = null;
$envioTest = null;
$valoracionTest = null;
$precioRebajadoTest = null;
$badgeDescuentoTest = "";
$badgeEnvioTest = "";
$valoracionFormateadaTest = null;
$descuentoPreview = "0%";

if (
    isset($_POST['precio_test']) &&
    isset($_POST['descuento_test']) &&
    isset($_POST['envio_test']) &&
    isset($_POST['valoracion_test'])
) {
    $precioTest = (float) $_POST['precio_test'];
    $descuentoTest = (float) $_POST['descuento_test'];
    $envioTest = (bool) $_POST['envio_test'];
    $valoracionTest = (float) $_POST['valoracion_test'];

    $precioRebajadoTest = calcular_precio_rebajado($precioTest, $descuentoTest);
    $badgeDescuentoTest = mostrar_badge_descuento($descuentoTest);
    $badgeEnvioTest = mostrar_badge_envio($envioTest);
    $valoracionFormateadaTest = formatear_valoracion($valoracionTest);
    $descuentoPreview = number_format($descuentoTest * 100, 0) . "%";
}

?>

<div class="box">

<h2>Probar ficha de producto</h2>

<form method="post" class="form-grid">

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
        <div class="form-help">Ejemplo: 49.95</div>
    </div>

    <div class="form-group">
        <label for="descuento_test">Descuento (de 0,00 a 1,00)</label>
        <input
            type="number"
            step="0.01"
            name="descuento_test"
            id="descuento_test"
            min="0"
            max="1"
            value="<?php echo isset($_POST['descuento_test']) ? htmlspecialchars($_POST['descuento_test']) : ''; ?>"
        >
        <div class="form-help">Ejemplo: 0.05 = 5% | 0.10 = 10% | 0.15 = 15%</div>
        <div class="porcentaje-preview">
            Equivale a: <?php echo $descuentoPreview; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="valoracion_test">Valoración</label>
        <input
            type="number"
            step="0.1"
            name="valoracion_test"
            id="valoracion_test"
            min="0"
            max="5"
            value="<?php echo isset($_POST['valoracion_test']) ? htmlspecialchars($_POST['valoracion_test']) : ''; ?>"
        >
        <div class="form-help">Valor entre 0 y 5</div>
    </div>

    <div class="form-group">
        <label for="envio_test">Envío gratis</label>
        <select name="envio_test" id="envio_test">
            <option value="1" <?php echo (isset($_POST['envio_test']) && $_POST['envio_test'] === '1') ? 'selected' : ''; ?>>Sí</option>
            <option value="0" <?php echo (isset($_POST['envio_test']) && $_POST['envio_test'] === '0') ? 'selected' : ''; ?>>No</option>
        </select>
        <div class="form-help">Decide si aparece el badge de envío</div>
    </div>

    <button type="submit">Comprobar</button>

</form>

<?php if ($precioTest !== null): ?>

<div class="result">
    <b>Precio original:</b> <?php echo formatear_precio($precioTest); ?><br><br>
    <b>Descuento introducido:</b> <?php echo number_format($descuentoTest, 2); ?> → <?php echo number_format($descuentoTest * 100, 0); ?>%<br><br>
    <b>Precio rebajado:</b> <?php echo formatear_precio($precioRebajadoTest); ?><br><br>
    <b>Valoración formateada:</b> <?php echo $valoracionFormateadaTest; ?><br><br>
    <?php echo $badgeDescuentoTest; ?>
    <?php echo $badgeEnvioTest; ?>
</div>

<?php endif; ?>

<p>

<b>Explicación:</b><br><br>

Aquí puedes probar manualmente cómo responden las funciones según los datos del producto.<br><br>

- <b>calcular_precio_rebajado()</b> calcula el precio final<br>
- <b>mostrar_badge_descuento()</b> genera la etiqueta del descuento<br>
- <b>mostrar_badge_envio()</b> añade el aviso de envío gratis<br>
- <b>formatear_valoracion()</b> prepara la puntuación visual<br><br>

Aunque el descuento se introduce entre <b>0,00 y 1,00</b>, al lado puedes ver a qué porcentaje equivale.

</p>

</div>



<div class="box">

<h2>Ficha de producto estilo WooCommerce</h2>

<div class="result">

<?php echo renderizar_ficha_producto($producto); ?>

</div>

<p>

<b>Explicación:</b><br><br>

Este ejercicio enseña cómo una ficha grande se apoya en varias funciones pequeñas.<br><br>

<b>Proceso de la ficha:</b><br><br>

1. Se leen los datos del producto.<br>
2. <b>calcular_precio_rebajado()</b> obtiene el nuevo precio.<br>
3. <b>mostrar_badge_descuento()</b> decide si aparece una etiqueta de descuento.<br>
4. <b>mostrar_badge_envio()</b> decide si aparece el badge de envío gratis.<br>
5. <b>formatear_valoracion()</b> transforma la puntuación en texto legible.<br>
6. <b>renderizar_ficha_producto()</b> junta todo y construye el HTML final.<br><br>

Así se ve mejor que una función grande puede apoyarse en varias funciones pequeñas.

</p>

<div class="codigo">
datos producto → funciones pequeñas → ficha renderizada
</div>

</div>

</body>
</html>