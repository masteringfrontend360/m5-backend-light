<!DOCTYPE html>
<html>
<head><title>Ej3 Arrays</title></head>
<body>
<?php
// TODO: Crea el array $producto del Ejercicio 2
//$producto = [...];
$memoria_ram = [
'nombre' => 'DDR5-16GB',
'precio' => '180-Euros',
'stock' => 6
];
// TODO: Añade clave 'categoria' con un valor
$memoria_ram['categoria'] = 'DIMM';

// <!-- TODO: Cambia el valor de 'stock' -->
$memoria_ram['stock'] = '4';

// <!-- TODO: Elimina una clave que no necesites con unset() -->
unset($memoria_ram['precio']);

?>
<!-- TODO: Muestra el array modificado con print_r() -->
<pre><?php  print_r($memoria_ram); ?></pre>

</body>
</html>