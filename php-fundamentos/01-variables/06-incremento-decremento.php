<?php

// Ejercicio 6
// 1. Declara una variable $numero con valor inicial 5
// 2. Realiza pre-incremento
// 3. Realiza post-incremento
// 4. Realiza pre-decremento
// 5. Realiza post-decremento
// 6. Muestra los resultados en cada paso

$numero = 5;

$original = $numero;

$pre_incremento = ++$numero;
$post_incremento = $numero++;

$pre_decremento = --$numero;
$post_decremento = $numero--;

?>

<!DOCTYPE html>
<html>

<head>
<title>Ejercicio 6 PHP</title>

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

<h2>Incremento y decremento</h2>

<p>
En este ejercicio veremos cómo funcionan los operadores ++ y -- en PHP.
</p>

<div class="result">

Valor original → <?php var_dump($original); ?><br><br>

Pre-incremento (++$numero) → <?php var_dump($pre_incremento); ?><br><br>

Post-incremento ($numero++) → <?php var_dump($post_incremento); ?><br><br>

Pre-decremento (--$numero) → <?php var_dump($pre_decremento); ?><br><br>

Post-decremento ($numero--) → <?php var_dump($post_decremento); ?>

</div>

<p>

<b>Explicación:</b><br><br>

<b>++</b> aumenta el valor en 1.<br>
<b>--</b> reduce el valor en 1.<br><br>

<b>Pre-incremento</b> (++$numero)<br>
Primero cambia el valor y luego lo devuelve.<br><br>

<b>Post-incremento</b> ($numero++)<br>
Primero devuelve el valor y después lo incrementa.<br><br>

Lo mismo ocurre con el decremento.

</p>

</div>

</body>
</html>
