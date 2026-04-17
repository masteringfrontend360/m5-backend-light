Dispones de este array:

```php
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
];
```

Crea las siguientes funciones:

- `formatear_precio(float $precio): string`
- `obtener_estado_stock(int $stock): string`
- `obtener_clase_stock(int $stock): string`
- `mostrar_producto(array $producto): string`

Condiciones:

- `formatear_precio()` debe devolver el precio con dos decimales y el símbolo €.
- `obtener_estado_stock()` debe devolver:
    - `En stock` si hay 10 o más unidades.
    - `Quedan pocas unidades` si hay entre 1 y 9.
    - `Sin stock` si hay 0.
- `obtener_clase_stock()` debe devolver:
    - `stock-ok`
    - `stock-bajo`
    - `stock-agotado`
- `mostrar_producto()` debe devolver un `<article>` con nombre, precio y estado de stock.
- Recorre el array con un `foreach` y pinta todos los productos.

Objetivo:

- Empezar a dividir una tarea en funciones pequeñas y reutilizables.
- Preparar lógica que luego podría llevarse a una plantilla de tema o plugin.