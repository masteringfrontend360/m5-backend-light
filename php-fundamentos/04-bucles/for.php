<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Bucle for</title>

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
    padding:10px;
    margin-top:10px;
}

</style>

</head>

<body>


<div class="box">

<h2>Ejercicio 1 – números del 1 al 50 con for</h2>

<?php

$numeros = [];

for ($i = 1; $i <= 50; $i++) {
    $numeros[] = $i;
}

?>

<div class="result">
<?php echo implode(", ", $numeros); ?>
</div>

<p>

<b>Explicación:</b><br><br>

El bucle <b>for</b> tiene tres partes:<br>

inicio → <code>$i = 1</code><br>
condición → <code>$i <= 50</code><br>
actualización → <code>$i++</code>

</p>

</div>



<div class="box">

<h2>Ejercicio 2 – tablas de multiplicar del 1 al 10</h2>

<div class="result">

<?php

for ($tabla = 1; $tabla <= 10; $tabla++) {

    echo "<b>Tabla del $tabla</b><br>";

    for ($i = 1; $i <= 10; $i++) {

        $resultado = $tabla * $i;
        echo "$tabla x $i = $resultado<br>";

    }

    echo "<br>";
}

?>

</div>

<p>

<b>Explicación:</b><br><br>

Usamos dos bucles <b>for</b> anidados:

<br><br>

for exterior → recorre las tablas del 1 al 10<br>
for interior → recorre los multiplicadores del 1 al 10

</p>

</div>


</body>
</html>