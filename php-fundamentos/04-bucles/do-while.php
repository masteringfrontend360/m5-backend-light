<?php
// do_while.php

// Ejercicio 1: Mostrar todos los números múltiplos de 15
// entre 30 y 75, ambos incluidos.
$i = 30;

echo "Múltiplos de 15 entre 30 y 75:<br>";

do {
    if ($i % 15 == 0) {
        echo $i . " ";
    }
    $i++;
} while ($i <= 75);
echo "<br><br>";

// Ejercicio 2: Sumar todos los números impares entre 0 y 10.

$i = 0;
$suma = 0;

do {
    if ($i % 2 != 0) {
        $suma += $i;
    }
    $i++;
} while ($i <= 10);

echo "La suma de los números impares entre 0 y 10 es: $suma";

// Ejercicio 3: Mostrar la tabla de multiplicar del 2,
// del 1 al 10, dentro de una tabla HTML.
$i = 1;

echo "<h3>Tabla del 2</h3>";
echo "<table border='1' cellpadding='5'>";

do {
    $resultado = 2 * $i;
    echo "<tr>
            <td>2 x $i</td>
            <td>$resultado</td>
          </tr>";
    $i++;
} while ($i <= 10);

echo "</table>";