<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 2 Arrays</title>

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

h2{
    color:#333;
}

.result{
    background:#eef;
    padding:10px;
    margin-top:10px;
}

</style>

</head>

<body>

<?php

// Creamos un array asociativo de producto

$producto = [
    'nombre' => 'Teclado mecánico',
    'precio' => 89.95,
    'stock' => 12
];

// Accedemos a los datos

$nombre = $producto['nombre'];
$precio = $producto['precio'];

?>

<div class="box">

<h2>Array asociativo</h2>

<p>
En este ejercicio creamos un array asociativo que representa un producto.
</p>

<div class="result">

Nombre del producto → <?php echo $nombre; ?><br><br>

Precio del producto → <?php echo $precio; ?> €

</div>

<p>

<b>Explicación:</b><br><br>

Un <b>array asociativo</b> usa claves de texto en lugar de índices numéricos.<br><br>

Ejemplo de estructura:<br>

nombre → Teclado mecánico<br>
precio → 89.95<br>
stock → 12<br><br>

Para acceder a un valor usamos la clave:<br>

<b>$producto['nombre']</b><br>
<b>$producto['precio']</b>

</p>

</div>

</body>
</html>