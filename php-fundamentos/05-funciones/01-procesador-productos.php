<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Array multidimensional + ordenación + mostrar en HTML.</title>
    <style>
        .stock-bajo {
            color:red;
        }
        .stock-ok {
            color:green;
        }
        .stock-agotado {
            color:grey;
        }

    </style>
</head>

<body>
<!-- Dispones de este array: -->


<?php
$productos = [
    [
        'nombre' => 'Camiseta WordPress',
        'precio' => 19.9,
        'stock' => 8,
        'categoria' => 'merchandising',
    ],
    [
        'nombre' => 'Taza WooCommerce',
        'precio' => 12.5,
        'stock' => 24,
        'categoria' => 'hogar',
    ],
    [
        'nombre' => 'Sudadera Gutenberg',
        'precio' => 39,
        'stock' => 3,
        'categoria' => 'ropa',
    ],
    [
        'nombre' => 'Bolsitas de te Wordpress',
        'precio' => 4,
        'stock' => 0,
        'categoria' => 'ropa',
    ],
];
?>


<!-- Crea las siguientes funciones:
 - `formatear_precio()` debe devolver el precio con dos decimales y el símbolo €.
 - `formatear_precio(float $precio): string` -->
<?php function formatear_precio(float $precio): string {
    return
    number_format($precio, 2) . " €";
} 
?>

<!-- - `obtener_estado_stock(int $stock): string`
- `obtener_estado_stock()` debe devolver:
- `En stock` si hay 10 o más unidades.
- `Quedan pocas unidades` si hay entre 1 y 9.
- `Sin stock` si hay 0. -->
<?php function obtener_estado_stock(int $stock): string {
    if ($stock === 0) {
    return "Sin Stock.";
    } else if ($stock <= 9) {
        return "Quedan pocas unidades.";
    } else {
        return "En Stock.";
    }
}
?>
<!-- - `obtener_clase_stock(int $stock): string`
 - `obtener_clase_stock()` debe devolver:
 - `stock-ok`
 - `stock-bajo`
 - `stock-agotado` -->
<?php function obtener_clase_stock(int $stock): string {
    if ($stock === 0) {
        return "stock-agotado";
    } else if ($stock <= 9) {
        return "stock-bajo";
    } else {
        return "stock-ok";
    }
}
?>

<!-- - `mostrar_producto(array $producto): string`
 - `mostrar_producto()` debe devolver un `<article>` con nombre, precio y estado de stock. -->
<?php function mostrar_producto(array $producto): string {
    return '
     <article class="' . obtener_clase_stock($producto["stock"]) . '">
        <h2>' . $producto["nombre"] . '</h2>
        <p>' . formatear_precio($producto["precio"]) . '</p>
        <p>' . obtener_estado_stock($producto["stock"]) . '</p>
    </article>
    ';
}
?>
<!-- - Recorre el array con un `foreach` y pinta todos los productos.-->
<?php
foreach ($productos as $producto) {
    echo mostrar_producto($producto);
}
?>


 <!-- Objetivo:

 - Empezar a dividir una tarea en funciones pequeñas y reutilizables.
 - Preparar lógica que luego podría llevarse a una plantilla de tema o plugin.  -->

</body>

</html>