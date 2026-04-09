<?php

// Ejercicio 6
// 1. Declara una variable $numero con valor inicial 5
// 2. Realiza pre-incremento
// 3. Realiza post-incremento
// 4. Realiza pre-decremento
// 5. Realiza post-decremento
// 6. Muestra los resultados en cada paso

// 1. Declara una variable $numero con valor inicial 5
$n = 5;

// 2. Realiza pre-incremento --> Primero suma 1 y luego imprime 6
echo "Pre-incremento: " . ++$n;

// 3. Realiza post-incremento --> Primero imprime 6 y luego suma 1
echo "<br>Post-incremento: " . $n++;

// 4. Realiza pre-decremento --> Primero resta 1 y luego imprime 6
echo "<br>Pre-decremento: " . --$n;

// 5. Realiza post-decremento --> Primero imprime 6 y luego resta 1
echo "<br>Post-incremento: " . $n--;

