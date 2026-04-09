<!DOCTYPE html>
<html>
<head><title>Ej4 Arrays</title></head>
<body>
<?php
// TODO: Crea array $productos con 2 arrays asociativos (cada uno con 'nombre' y 'precio')
$productos = [
[
'nombre' => 'camiseta',
'precio' => 19.99
],
[
'nombre' => 'pantalón',
'precio' => 39.99
]
];
// TODO: Accede y muestra el nombre del segundo producto (índice 1)
echo $productos[1]['nombre'] . " ";
?>
</body>
</html>