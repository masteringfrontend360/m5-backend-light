<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
$nombre = "Juan"; // String
$edad = 30; // Integer
$esEstudiante = true; // Boolean
// 2. Crea una constante con tu nombre
define("MI_NOMBRE", "Juan");   
// 3. Haz una suma y muéstrala con echo 
$a = 5;
$b = 10;
$suma = $a + $b;
echo "La suma de $a y $b es: $suma";
// 4. Compara dos valores con == y con ===
$x = 5; // Integer
$y = "5"; // String

// Comparación con ===
if ($x === $y) {
    echo "Con ===, $x y $y son iguales.";
} else {
    echo "Con ===, $x y $y no son iguales.";
}
// 5. Usa var_dump() para ver el tipo de cada variable
var_dump($nombre);
var_dump($edad);
var_dump($esEstudiante);
var_dump(MI_NOMBRE);
var_dump($suma);
var_dump($x);
var_dump($y);