<h1>Ejercicio variables de tipos</h1>
<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo

$nombre = "mayckel";
$edad = 18;
$altura = 1.82;

// 2. Crea una constante con tu nombre

const nombre_completo = "mayckel araujo";

// 3. Haz una suma y muéstrala con echo

$m = 18;
$n = 12;
$e = $m + $n;
$suma = $m + $n;
echo $e . "<br>";
echo $suma . "<br> <br>";

// 4. Compara dos valores con == y con ===

$año = 2024;
$numero = "2024";

var_dump($año == $numero);
var_dump($año === $numero);

// 5. Usa var_dump() para ver el tipo de cada variable

var_dump($nombre, $edad, $altura);
