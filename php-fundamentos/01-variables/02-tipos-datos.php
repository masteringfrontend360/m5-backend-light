<?php

$numero = 42;
$decimal = 19.95;
$texto = "Hola mundo";
$activo = true;
$frutas = ["manzana", "pera", "uva"];

?>

<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 2 PHP</title>

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

<div class="box">
<h2>Tipos de datos en PHP</h2>

<p>
En este ejercicio creamos una variable de cada tipo:
</p>

<div class="result">

Numero → <?php var_dump($numero); ?><br><br>

Decimal → <?php var_dump($decimal); ?><br><br>

Texto → <?php var_dump($texto); ?><br><br>

Booleano → <?php var_dump($activo); ?><br><br>

Array → <?php var_dump($frutas); ?>

</div>

<p>

<b>Explicación:</b><br><br>

<b>int</b> → número entero.<br>
Ejemplo: 42<br><br>

<b>float</b> → número con decimales.<br>
Ejemplo: 19.95<br><br>

<b>string</b> → texto.<br>
Ejemplo: "Hola mundo"<br><br>

<b>bool</b> → verdadero o falso.<br>
Ejemplo: true<br><br>

<b>array</b> → lista de valores.<br>
Ejemplo: manzana, pera, uva.

</p>

</div>

</body>
</html>
