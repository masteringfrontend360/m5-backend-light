<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
// 2. Crea una constante con tu nombre
// 3. Haz una suma y muéstrala con echo
// 4. Compara dos valores con == y con ===
// 5. Usa var_dump() para ver el tipo de cada variable

$edad = 41;
$precio = 19.99;
$nombre = "Antonio";

define("MI_NOMBRE", "Antonio Blánquez");

$suma = $edad + 10;

$a = 5;
$b = "5";
?>

<!DOCTYPE html>
<html>
<head>
<title>Ejercicio 1 PHP</title>

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
<h2>1️⃣ Variables</h2>

<p>Hemos creado tres variables:</p>

<div class="result">
edad = <?php echo $edad ?><br>
precio = <?php echo $precio ?><br>
nombre = <?php echo $nombre ?>
</div>

<p>
edad → número entero (int)<br>
precio → número decimal (float)<br>
nombre → texto (string)
</p>

</div>



<div class="box">
<h2>2️⃣ Constante</h2>

<div class="result">
Constante MI_NOMBRE = <?php echo MI_NOMBRE ?>
</div>

<p>
Una constante es un valor que no cambia durante la ejecución.
</p>

</div>



<div class="box">
<h2>3️⃣ Operación matemática</h2>

<div class="result">
La suma es: <?php echo $suma ?>
</div>

<p>
41 + 10 = 51
</p>

</div>



<div class="box">
<h2>4️⃣ Comparaciones</h2>

<div class="result">
Comparación con == : <?php var_dump($a == $b); ?><br>
Comparación con === : <?php var_dump($a === $b); ?>
</div>

<p>
== compara solo el valor.<br>
=== compara valor y tipo.
</p>

</div>



<div class="box">
<h2>5️⃣ Tipos de variables</h2>

<div class="result">
Edad → <?php var_dump($edad); ?><br>
Precio → <?php var_dump($precio); ?><br>
Nombre → <?php var_dump($nombre); ?>
</div>

<p>
string(7) significa que el texto tiene 7 caracteres.
</p>

</div>

</body>
</html>
