<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
// 2. Crea una constante con tu nombre
// 3. Haz una suma y muéstrala con echo
// 4. Compara dos valores con == y con ===
// 5. Usa var_dump() para ver el tipo de cada variable

$nombre = 'Delia';
$edad = 51;
$profe = true;

define ('NOMBRE', 'Ana Delia Campo');

$n1 = 1;
$n2 = 3;
$suma = $n1 + $n2;

echo "La suma de $n1 + $ $n2 = $suma";

var_dump(5=='5'); // true
var_dump(5==='5'); // false
var_dump($nombre, $edad, $profe);
