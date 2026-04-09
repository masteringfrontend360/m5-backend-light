<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Break y Continue</title>

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

<h2>Ejercicio 1 – break</h2>

<?php

$divisible = null;

for ($i = 1; $i <= 100; $i++) {

    if ($i % 7 === 0) {
        $divisible = $i;
        break;
    }

}

?>

<div class="result">
Primer número divisible por 7 entre 1 y 100 → <?php echo $divisible; ?>
</div>

<p>
<b>Explicación:</b><br><br>
Recorremos los números del 1 al 100.<br>
Cuando encontramos el primer número divisible por 7 usamos <b>break</b> para detener el bucle.
</p>

</div>



<div class="box">

<h2>Ejercicio 2 – continue</h2>

<?php

$numeros = [];

for ($i = 1; $i <= 20; $i++) {

    if ($i % 3 === 0) {
        continue;
    }

    $numeros[] = $i;
}

?>

<div class="result">

Números del 1 al 20 saltando múltiplos de 3:<br><br>

<?php echo implode(", ", $numeros); ?>

</div>

<p>

<b>Explicación:</b><br><br>

Si un número es múltiplo de 3 usamos <b>continue</b> para saltar esa iteración.<br>
El bucle sigue con el siguiente número.

</p>

</div>

</body>
</html>