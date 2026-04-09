<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
$numero = 5;
$decimal = 3.14;
$cadena = "Hola, soy una cadena de texto";

// 2. Crea una constante con tu nombre
define("NOMBRE", "Tu Nombre");

// 3. Haz una suma y muéstrala con echo
$suma = $numero + $decimal;
echo "La suma es: " . $suma . "<br>";

// 4. Compara dos valores con == y con ===
$valor1 = 5;
$valor2 = "5";
echo "Comparación con ==: " . ($valor1 == $valor2 ? "Iguales" : "Diferentes") . "<br>";
echo "Comparación con ===: " . ($valor1 === $valor2 ? "Iguales" : "Diferentes") . "<br>";

// 5. Usa var_dump() para ver el tipo de cada variable
var_dump($numero);
var_dump($decimal);
var_dump($cadena);
var_dump(NOMBRE);

?>