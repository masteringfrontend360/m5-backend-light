<?php
// while.php

// Ejercicio 1: Mostrar todos los números del 1 al 50, ambos incluidos.
$num = 1;
while ($num <= 50) {
echo $num++ . ", ";
}

// Ejercicio 2: Mostrar todos los números impares del 51 al 1, en orden descendente.
$num = 51;
while ($num >= 1) {
if ($num % 2 === 1) {
echo $num . ", ";
}
--$num;
}

// Ejercicio 3: Dados dos números ($num1 y $num2), comprobar que $num1 < $num2,
// mostrar todos los números comprendidos entre ellos y calcular la suma total.
$num1 = 7;
$num2 = 12;
$actual = $num1 + 1;
$suma = 0;

if ($actual < $num2) {
while ($actual < $num2) {
echo $actual;
$suma += $actual;
$actual++;
}
}
echo $suma;

// Ejercicio 4: Dado un número, indicar si es primo o no.
$num = 4;
$divisor = 2;
$primo = true;

while ($divisor < $num) {
    if ($num % $divisor === 0) {
    $primo = false;
    }
    $divisor++;
}

if ($primo === true) {
    echo "es primo";
} else {
    echo "no es primo";
}