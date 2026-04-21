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
<<<<<<< HEAD
var_dump($nombre);
var_dump($edad);
var_dump($esEstudiante);
var_dump(MI_NOMBRE);
var_dump($suma);
var_dump($x);
var_dump($y);
=======

$nombre = 'Delia';
$edad = 51;
$profe = true;

define ('NOMBRE', 'Ana Delia Campo');

$n1 = 1;
$n2 = 3;
$suma = $n1 + $n2;

echo "La suma de $n1 + $n2 = $suma";

var_dump(5=='5'); // true
var_dump(5==='5'); // false
var_dump($nombre, $edad, $profe);
>>>>>>> delia
