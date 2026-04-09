<?php

// Ejercicio 4
// 1. Define la constante IVA con valor 0.21
// 2. Define la constante TIENDA con el nombre de tu tienda
// 3. Calcula el precio final de un producto de 100
// 4. Muestra el nombre de la tienda y el precio final

define("IVA", 0.21);
define("TIENDA", "Mi Tienda");
$precioProducto = 100;
$precioFinal = $precioProducto * (1 + IVA);
echo "Tienda: " . TIENDA . "<br>";
echo "Precio final del producto: " . $precioFinal . "\n";
