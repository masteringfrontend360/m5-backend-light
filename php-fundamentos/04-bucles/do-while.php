<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Do While</title>

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

table{
    border-collapse: collapse;
}

td, th{
    border:1px solid #ccc;
    padding:8px;
}

</style>

</head>

<body>



<div class="box">

<h2>Ejercicio 1 – múltiplos de 15 entre 30 y 75</h2>

<?php

$numeros = [];
$i = 30;

do {

    if ($i % 15 === 0) {
        $numeros[] = $i;
    }

    $i++;

} while ($i <= 75);

?>

<div class="result">
<?php echo implode(", ", $numeros); ?>
</div>

<p>

<b>Explicación:</b><br><br>

Recorremos los números del 30 al 75.<br>
Si el número es divisible por 15 lo guardamos.<br>
El bucle se ejecuta al menos una vez porque es <b>do...while</b>.

</p>

</div>



<div class="box">

<h2>Ejercicio 2 – suma de impares entre 0 y 10</h2>

<?php

$suma = 0;
$i = 0;

do {

    if ($i % 2 !== 0) {
        $suma += $i;
    }

    $i++;

} while ($i <= 10);

?>

<div class="result">
Suma total → <?php echo $suma; ?>
</div>

<p>

<b>Explicación:</b><br><br>

Comprobamos si el número es impar usando <b>% 2</b>.<br>
Si lo es, lo sumamos al acumulador.

</p>

</div>



<div class="box">

<h2>Ejercicio 3 – tabla de multiplicar del 2</h2>

<?php

$i = 1;

?>

<div class="result">

<table>

<tr>
<th>Número</th>
<th>Resultado</th>
</tr>

<?php

do {

    $resultado = 2 * $i;

    echo "<tr>";
    echo "<td>2 x $i</td>";
    echo "<td>$resultado</td>";
    echo "</tr>";

    $i++;

} while ($i <= 10);

?>

</table>

</div>

<p>

<b>Explicación:</b><br><br>

El bucle <b>do...while</b> ejecuta primero el código y luego comprueba la condición.<br>
Por eso se usa cuando queremos garantizar al menos una ejecución.

</p>

</div>



</body>
</html>