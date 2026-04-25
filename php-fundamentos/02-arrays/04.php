<!DOCTYPE html>
<html>
<head><title>Ej4 Arrays</title></head>
<body>
<?php
// Crea array $productos con 2 arrays asociativos (cada uno con 'nombre' y 'precio')
$productos = [
[
    "nombre" => "Air Jordan 1 Mid",
    "precio" => 97.99
],
[
    "nombre" => "Air Jordan OG",
    "precio" => 149.99
]
];
// Accede y muestra el nombre del segundo producto (índice 1)
echo $productos [1]["nombre"];

?>
</body>
</html>