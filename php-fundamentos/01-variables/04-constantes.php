<?php

// Ejercicio 4
// 1. Define la constante IVA con valor 0.21
define( "IVA", 0.21 );
// 2. Define la constante TIENDA con el nombre de tu tienda
define( "TIENDA", "ARO+" );
// 3. Calcula el precio final de un producto de 100
$precio = 100;
$precioFinal = $precio + ($precio * IVA);
// 4. Muestra el nombre de la tienda y el precio final
echo "Nombre de la tienda: " . TIENDA . "<br>";
echo "Precio final: " . $precioFinal . "<br>";