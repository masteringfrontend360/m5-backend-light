<!DOCTYPE html>
<html>
<head><title>Ej4 Arrays</title></head>
<body>
<?php
// TODO: Crea array $productos con 2 arrays asociativos (cada uno con 'nombre' y 'precio')

// TODO: Accede y muestra el nombre del segundo producto (índice 1)

$frutas = [
    ['nombre'=> 'manzanas',
     'precio'=> 10],

    ['nombre'=> 'peras',
     'precio'=> 8],

     ['nombre'=> 'uvas',
     'precio'=> 5]
];
echo $frutas[0]['nombre'];
echo "<br>";
echo $frutas[1]['precio'];
echo "<br>";
echo $frutas[2]['nombre'];


?>
</body>
</html>