<!DOCTYPE html>
<html>
<head><title>Ej3 Arrays</title></head>
<body>
<?php
// Crea el array $producto del Ejercicio 2
$producto = [
 'nombre' => 'Air Jordan 1 Mid',
 'precio' => 97.99,
 'stock' => true
 ];

// Añade clave 'categoria' con un valor
$producto["categoria"] = "zapatillas";

// Cambia el valor de 'stock' 
$producto["stock"] = false;


// Elimina una clave que no necesites con unset() 
unset($producto["stock"]);
?>

<!-- Muestra el array modificado con print_r() -->
<pre><?php print_r($producto); ?></pre>

</body>
</html>