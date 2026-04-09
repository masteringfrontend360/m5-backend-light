<?php
// Ejercicio 1

$edad = 30;
$notas = 18.5;
$nombre = "autanafronted";

// Constante corregida
const MI_NOMBRE = "ernesto";

$ssuma = $edad + $notas;
echo "La suma es: " . $ssuma . "<br><br>";

echo "El nombre ". $nombre ." no es igual a la constante ". MI_NOMBRE . "<br><br>";

if ($edad == $notas) {
    echo "La edad y las notas son iguales";
    echo "<br><br>"; 
} else {
    echo "La edad y las notas NO son iguales";
}
echo "<br><br>";

var_dump($edad);
echo "<br><br>";
var_dump($notas);
echo "<br><br>";
var_dump($nombre);
echo "<br><br>";
var_dump(MI_NOMBRE);

