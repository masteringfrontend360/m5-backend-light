<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
$numero = 5;
$decimal = 3.14;
$cadena = "Hola, soy una cadena de texto";

// 2. Crea una constante con tu nombre
define("NOMBRE", "Ana");

// 3. Haz una suma y muéstrala con echo
$suma = $numero + $decimal;
echo "La suma es: " . $suma . "<br>";

// 4. Compara dos valores con == y con ===
$valor1 = 5;
$valor2 = "5";
echo "Comparación con ==: " . ($valor1 == $valor2 ? "Iguales" : "Diferentes") . "<br>";
echo "Comparación con ===: " . ($valor1 === $valor2 ? "Iguales" : "Diferentes") . "<br>";
//prueba de commit
// 5. Usa var_dump() para ver el tipo de cada variable
<<<<<<< HEAD
var_dump($numero);
var_dump($decimal);
var_dump($cadena);
var_dump(NOMBRE);

?>
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
>>>>>>> origin/delia
