<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 4 Arrays</title>

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

// Creamos un array con dos productos (array multidimensional)

$productos = [

    [
        'nombre' => 'Teclado mecánico',
        'precio' => 89.95
    ],

    [
        'nombre' => 'Ratón gaming',
        'precio' => 49.95
    ]

];

// Accedemos al nombre del segundo producto

$segundo_producto = $productos[1]['nombre'];

?>

<div class="box">

<h2>Arrays multidimensionales</h2>

<p>
En este ejercicio creamos un array que contiene varios productos.
</p>

<div class="result">

Nombre del segundo producto → <?php echo $segundo_producto; ?>

</div>

<p>

<b>Explicación:</b><br><br>

Un <b>array multidimensional</b> es un array que contiene otros arrays.<br><br>

En este caso tenemos una lista de productos:<br><br>

Producto 0 → Teclado mecánico<br>
Producto 1 → Ratón gaming<br><br>

Para acceder usamos dos niveles:<br><br>

<b>$productos[1]['nombre']</b><br><br>

1 → segundo producto<br>
'nombre' → campo dentro del producto.

</p>

</div>

</body>
</html>