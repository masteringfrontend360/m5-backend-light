<?php

$numero = 10;
$mensaje = "Hola";

$numero_original = $numero;
$mensaje_original = $mensaje;

$numero = $numero + 5;
$mensaje .= " Antonio";

?>

<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 3 PHP</title>

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

<h2>Variables y modificación</h2>

<p>
Primero declaramos dos variables:
</p>

<div class="result">

Numero original → <?php var_dump($numero_original); ?><br><br>

Mensaje original → <?php var_dump($mensaje_original); ?>

</div>

<p>
Ahora modificamos las variables:
</p>

<div class="result">

Numero modificado → <?php var_dump($numero); ?><br><br>

Mensaje modificado → <?php var_dump($mensaje); ?>

</div>

<p>

<b>Explicación:</b><br><br>

El número se modifica sumando 5.<br>

10 + 5 = 15.<br><br>

El texto se modifica usando el operador <b>.=</b>.<br>

Este operador sirve para concatenar texto.<br><br>

Ejemplo:<br>

"Hola" . " Antonio" → Hola Antonio

</p>

</div>

</body>
</html>
