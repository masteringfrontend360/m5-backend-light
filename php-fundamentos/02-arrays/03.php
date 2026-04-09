<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 3 Arrays</title>

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

// Creamos el array del ejercicio anterior

$producto = [
    'nombre' => 'Teclado mecánico',
    'precio' => 89.95,
    'stock' => 12
];

// Añadimos una nueva clave

$producto['categoria'] = 'Periféricos';

// Cambiamos el valor del stock

$producto['stock'] = 20;

// Eliminamos una clave que ya no necesitamos

unset($producto['precio']);

?>

<div class="box">

<h2>Modificar arrays</h2>

<p>
En este ejercicio modificamos un array asociativo.
</p>

<div class="result">

<pre><?php print_r($producto); ?></pre>

</div>

<p>

<b>Explicación:</b><br><br>

Añadir una clave:<br>
$producto['categoria'] = 'Periféricos';<br><br>

Modificar un valor:<br>
$producto['stock'] = 20;<br><br>

Eliminar una clave:<br>
unset($producto['precio']);<br><br>

print_r() sirve para visualizar arrays completos de forma legible.

</p>

</div>

</body>
</html>