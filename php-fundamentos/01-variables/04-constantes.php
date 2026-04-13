<?php

// Ejercicio 4
// 1. Define la constante IVA con valor 0.21
define( "IVA", 0.21 );
// 2. Define la constante TIENDA con el nombre de tu tienda
define( "TIENDA", "ARO+" );
// 3. Calcula el precio final de un producto de 100
// 4. Muestra el nombre de la tienda y el precio final

// 1. Define la constante IVA con valor 0.21
define("IVA", 0.21);

// 2. Define la constante TIENDA con el nombre de tu tienda
define("TIENDA", "Beats4life");

// 3. Calcula el precio final de un producto de 100
define("PRECIO_SIN_IVA", 100);
define("PRECIO_CON_IVA", PRECIO_SIN_IVA - PRECIO_SIN_IVA * IVA);

// 4. Muestra el nombre de la tienda y el precio final
echo "Tienda: " . TIENDA . "<br>Precio: " . PRECIO_CON_IVA;
