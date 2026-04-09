<?php

// Ejercicio 5
// 1. Declara dos números
// 2. Realiza suma
// 3. Realiza resta
// 4. Realiza multiplicación
// 5. Realiza división
// 6. Muestra todos los resultados

$num1 = 10;
$num2 = 5;

$suma = $num1 + $num2;
$resta = $num1 - $num2;
$multiplicacion = $num1 * $num2;
$division = $num2 != 0 ? $num1 / $num2 : "No se puede dividir por cero";
echo "Suma: $suma<br>";
echo "Resta: $resta<br>";
echo "Multiplicación: $multiplicacion<br>";
echo "División: $division<br>";
