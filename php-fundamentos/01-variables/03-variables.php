<?php

// Ejercicio 3
// 1. Declara una variable entera y una cadena de texto
$entero = 777;
$cadena = "hola, me mude al file 03-variables.php";

// 2. Muestra sus valores iniciales
echo "valor inicial de la variable entera: " . $entero . "<br>";
echo "valor inicial de la variable cadena: " . $cadena . "<br>";

// 3. Cambia el valor de la variable entera
$entero = 888;

// 4. Concatena texto a la cadena
$cadena .= "ahora tiene un valor diferente, viva 777";

// 5. Muestra los valores finales
echo "ahora mostramos los valores finales: " . $entero . "<br>" . $cadena;
