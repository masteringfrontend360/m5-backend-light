<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Bucle while</title>

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

<h2>Ejercicio 1 – números del 1 al 50</h2>

<?php

$i = 1;
$numeros = [];

while ($i <= 50) {
    $numeros[] = $i;
    $i++;
}

?>

<div class="result">
<?php echo implode(", ", $numeros); ?>
</div>

</div>



<div class="box">

<h2>Ejercicio 2 – impares del 51 al 1</h2>

<?php

$i = 51;
$numeros = [];

while ($i >= 1) {

    if ($i % 2 !== 0) {
        $numeros[] = $i;
    }

    $i--;
}

?>

<div class="result">
<?php echo implode(", ", $numeros); ?>
</div>

</div>



<div class="box">

<h2>Ejercicio 3 – números entre dos valores</h2>

<?php

$num1 = 5;
$num2 = 15;

$numeros = [];
$suma = 0;

if ($num1 < $num2) {

    $i = $num1 + 1;

    while ($i < $num2) {

        $numeros[] = $i;
        $suma += $i;

        $i++;
    }

}

?>

<div class="result">

Números entre <?php echo $num1; ?> y <?php echo $num2; ?>:<br><br>

<?php echo implode(", ", $numeros); ?>

<br><br>

Suma total → <?php echo $suma; ?>

</div>

</div>



<div class="box">

<h2>Ejercicio 4 – número primo</h2>

<?php

$numero = 17;

$i = 2;
$esPrimo = true;

while ($i < $numero) {

    if ($numero % $i === 0) {
        $esPrimo = false;
        break;
    }

    $i++;
}

?>

<div class="result">

Número → <?php echo $numero; ?><br><br>

Resultado → 

<?php
if ($esPrimo) {
    echo "Es primo";
} else {
    echo "No es primo";
}
?>

</div>

</div>



</body>
</html>