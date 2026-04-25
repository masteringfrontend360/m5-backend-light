<?php


// 1. Declara dos números
$manzanas = 7;
$peras = 4;

// 2. Realiza suma
define ("SUMA", $manzanas + $peras);

// 3. Realiza resta
define ("RESTA", $manzanas - $peras);

// 4. Realiza multiplicación
define ("MULTIPLICACION", $manzanas * $peras);

// 5. Realiza división
define ("DIVISION", $manzanas / $peras);

// 6. Muestra todos los resultados
echo "Manzanas: " . $manzanas . "<br>Peras: " . $peras;
echo "<br><br>Suma: " . SUMA;
echo "<br>Resta: " . RESTA;
echo "<br>Multiplicacion: " . MULTIPLICACION;
echo "<br>Division: " . DIVISION;
