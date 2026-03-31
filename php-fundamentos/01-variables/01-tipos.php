<?php

// Ejercicio 1: Tipos, variables, constantes y comparaciones
// Ana Delia Campo

// 1. Variables de distinto tipo
$nombre = "Ana Delia";    // string
$edad = 30;              // int
$altura = 1.75;          // float

// 2. Constante
const NOMBRE_COMPLETO = "Ana Delia Campo";

// 3. Suma con echo
$suma = 20 + 10;
echo "La suma es: $suma\n";

// 4. Comparaciones == (no estricto) vs === (estricto)
$v1 = 5;
$v2 = "5";

echo "5 == '5': " . ($v1 == $v2 ? 'true' : 'false') . "\n";
echo "5 === '5': " . ($v1 === $v2 ? 'true' : 'false') . "\n";

// 5. Tipos y valores
echo "\n--- var_dump() ---\n";
var_dump($nombre);
var_dump($edad);
var_dump($altura);
var_dump($v1 == $v2);
var_dump($v1 === $v2);