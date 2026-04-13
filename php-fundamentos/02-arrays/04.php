<!DOCTYPE html>
<html>
<head><title>Ej4 Arrays</title></head>
<body>
<?php
// TODO: Crea array $productos con 2 arrays asociativos (cada uno con 'nombre' y 'precio')
$componentes = array(
    $memoria_ram = [
        'nombre' => 'DDR5-16GB',
        'precio' => '180-Euros',
        'stock' => 6
    ],
    $tarjeta_grafica = [
        'nombre' => 'Rtx-1080TI',
        'precio' => '400-Euros',
        'stock' => '3'
    ]
);
// TODO: Accede y muestra el nombre del segundo producto (índice 1)
?>
<pre><?php  print_r($tarjeta_grafica['nombre']); ?></pre>
</body>
</html>