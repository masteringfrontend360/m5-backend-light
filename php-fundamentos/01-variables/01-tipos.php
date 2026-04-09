<?php
// Ejercicio 1
// 1. Declara 3 variables de distinto tipo
// 2. Crea una constante con tu nombre
// 3. Haz una suma y muéstrala con echo
// 4. Compara dos valores con == y con ===
// 5. Usa var_dump() para ver el tipo de cada variable


// 1. Declara 3 variables de distinto tipo
$cancion = "Ain´t No Sunshine";
$artista = "Bill Withers";
$album = "Just As I Am";

// 2. Crea una constante con tu nombre
const SERGIO = [
    "nombre" => "Sergio",
    "apellido1" => "Martinez",
    "apellido2" => "Aramburu",
    "edad" => 31,
    "origen" => "Zaragoza"
];

// 3. Haz una suma y muéstrala con echo
$a = 25;
$b = 50;
$suma_ab = $a + $b;

echo $suma_ab;

// 4. Compara dos valores con == y con ===
2 == "2";
2 === "2";

// 5. Usa var_dump() para ver el tipo de cada variable
