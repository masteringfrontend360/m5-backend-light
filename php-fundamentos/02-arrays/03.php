<!DOCTYPE html>
<html>
<head><title>Ej3 Arrays</title></head>
<body>
<?php
// TODO: Crea el array $producto del Ejercicio 2
//$producto = [...];

// TODO: Añade clave 'categoria' con un valor

$producto = [
    'nombre' => 'telefono',
    'marca' => 'samsung',
    'precio' => 300,
    'stock' => 'si'
];
$producto['categoria'] ='electronica';

echo $producto['categoria'];
echo "<br><br>";

$producto['stock'] = 'no';
echo $producto['stock'];
echo "<br><br>";

unset($producto['marca']);
print_r ($producto);


?>

<!-- TODO: Cambia el valor de 'stock' -->

<!-- TODO: Elimina una clave que no necesites con unset() -->

<!-- TODO: Muestra el array modificado con print_r() -->
<pre><?php /* print_r($producto); */ ?></pre>
</body>
</html>