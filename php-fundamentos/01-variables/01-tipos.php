<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
// 2. Crea una constante con tu nombre
// 3. Haz una suma y muéstrala con echo
// 4. Compara dos valores con == y con ===
// 5. Usa var_dump() para ver el tipo de cada variable
// Prueba RAma mayckel

<?php 
$entero = 5;
$flotante = 3.14;
$cadena = "Hola, mundo!";
const NOMBRE = "Mayckel";

$suma = $entero + $flotante;
echo $suma . "\n";

var_dump($entero);
var_dump($flotante);
var_dump($cadena);
var_dump(NOMBRE);
?>