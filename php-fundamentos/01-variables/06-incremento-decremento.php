<?php

// Ejercicio 6
// 1. Declara una variable $numero con valor inicial 5
// 2. Realiza pre-incremento
// 3. Realiza post-incremento
// 4. Realiza pre-decremento
// 5. Realiza post-decremento
// 6. Muestra los resultados en cada paso

$numero = 5;
echo "Valor inicial: $numero<br>";
// Pre-incremento
echo "Pre-incremento: " . ++$numero . "<br>"; // $numero
echo "Valor después del pre-incremento: $numero<br>";
// Post-incremento
echo "Post-incremento: " . $numero++ . "<br>"; // $numero
echo "Valor después del post-incremento: $numero<br>";
// Pre-decremento
echo "Pre-decremento: " . --$numero . "<br>"; // $numero
echo "Valor después del pre-decremento: $numero<br>";
// Post-decremento
echo "Post-decremento: " . $numero-- . "<br>"; // $numero
echo "Valor después del post-decremento: $numero<br>";


