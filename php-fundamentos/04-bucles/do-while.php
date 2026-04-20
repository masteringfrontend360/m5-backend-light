<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Array multidimensional + ordenación + mostrar en HTML.</title>
</head>

<body>

<?php
// do_while.php

// Ejercicio 1: Mostrar todos los números múltiplos de 15
// entre 30 y 75, ambos incluidos.

$contador = 30;

do {
    if ($contador % 15 === 0) {
        echo $contador . ", ";
    }
    $contador++;
} while ($contador <= 75);
?>


<?php
// Ejercicio 2: Sumar todos los números impares entre 0 y 10.

$contador = 0;
$suma = 0;

do {
    if ($contador % 2 !== 0) {
        $suma += $contador;
    }
    $contador++;
} while ($contador < 10);

echo $suma;
?>


<!-- Ejercicio 3: Mostrar la tabla de multiplicar del 2,
del 1 al 10, dentro de una tabla HTML. -->

<table border="1">

<?php
$numero = 2;
$multiplicador = 1;

do {
    $resultado = $numero * $multiplicador;
    echo "<tr><td>$resultado</td></tr>";
    $multiplicador++;
} while ($multiplicador <= 10);
?>

</table>

</body>

</html>