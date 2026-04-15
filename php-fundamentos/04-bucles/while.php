<?php
// while.php

// Ejercicio 1: Mostrar todos los números del 1 al 50, ambos incluidos.

$i = 1;
while ($i <= 50) {
    echo $i . " ";
    $i++;
}

echo "<br><br>";
// Ejercicio 2: Mostrar todos los números impares del 51 al 1, en orden descendente.

$i= 51;
while ($i >= 1) {
    if ($i % 2 != 0) {
        echo $i . " ";
    }
    $i--;
}
echo "<br><br>";
// Ejercicio 3: Dados dos números ($num1 y $num2), comprobar que $num1 < $num2,

$num1 = 5;
$num2 = 10;
while ($num1 < $num2) {
    echo "Números válidos: num1 es menor que num2.";
    break;
}

echo "<br>";

// mostrar todos los números comprendidos entre ellos y calcular la suma total.




// Ejercicio 4: Dado un número, indicar si es primo o no.