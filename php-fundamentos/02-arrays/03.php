<!DOCTYPE html>
<html>
<head><title>Ej3 Arrays</title></head>
<body>
<?php
// TODO: Crea el array $producto del Ejercicio 2
//$producto = [...];
$producto = [
 'nombre' => 'maria',
 'precio' => 10.99,
 'stock' => 6
 ];
// TODO: Añade clave 'categoria' con un valor
$producto['categoria'] = 'ropa';
// <!-- TODO: Cambia el valor de 'stock' -->
$producto['stock'] = 10;
// <!-- TODO: Elimina una clave que no necesites con unset() -->
unset($producto['precio']);
?>
<!-- TODO: Muestra el array modificado con print_r() -->
<pre><?php  print_r($producto);  ?></pre>
</body>
</html>