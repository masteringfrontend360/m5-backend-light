<!DOCTYPE html>
<html>
<head><title>Ej2 Arrays</title></head>
<body>
<?php
// TODO: Crea array asociativo $producto con claves 'nombre', 'precio' y 'stock'
/*
$producto = [
 'nombre' => '...',
 'precio' => ...,
 'stock' => ...
 ];
 */
// TODO: Muestra el nombre
// TODO: Muestra el precio

$producto = [
    'nombre' => 'telefono',
    'marca' => 'samsung',
    'precio' => 300,
    'stock' => 'si'
];

// Mostrar el nombre
echo $producto['nombre'];

echo "<br><br>";

// Mostrar el precio
echo $producto['precio'];

?>
</body>
</html>