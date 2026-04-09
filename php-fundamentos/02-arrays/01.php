<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 1 Arrays</title>

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

// Creamos un array indexado con 4 tecnologías

$tecnologias = ["HTML", "CSS", "PHP", "JavaScript"];

// Primer elemento
$primer = $tecnologias[0];

// Último elemento
$ultimo = $tecnologias[count($tecnologias) - 1];

?>

<div class="box">

<h2>Arrays indexados</h2>

<p>
En este ejercicio creamos un array con tecnologías que conocemos.
</p>

<div class="result">

Primer elemento → <?php echo $primer; ?><br><br>

Último elemento → <?php echo $ultimo; ?>

</div>

<p>

<b>Explicación:</b><br><br>

Un <b>array indexado</b> guarda elementos usando posiciones numéricas.<br><br>

Los índices empiezan en <b>0</b>.<br><br>

Ejemplo:<br>
HTML → índice 0<br>
CSS → índice 1<br>
PHP → índice 2<br>
JavaScript → índice 3<br><br>

Para obtener el último elemento usamos:<br>

<b>count($array) - 1</b>

</p>

</div>

</body>
</html>