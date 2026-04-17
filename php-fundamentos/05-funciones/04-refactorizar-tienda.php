Parte de este código inicial, que funciona pero está mal planteado:

```php
<?php

$productos = [
    ['nombre' => 'Camiseta', 'precio' => 20, 'stock' => 12],
    ['nombre' => 'Taza', 'precio' => 8.5, 'stock' => 2],
    ['nombre' => 'Pegatina', 'precio' => 2.25, 'stock' => 0],
];

foreach ($productos as $producto) {
    echo "<div>";
    echo "<h2>" . $producto['nombre'] . "</h2>";
    echo "<p>Precio: " . number_format($producto['precio'], 2) . "€</p>";

    if ($producto['stock'] > 10) {
        echo "<p>Disponible</p>";
    } elseif ($producto['stock'] > 0) {
        echo "<p>Quedan pocas unidades</p>";
    } else {
        echo "<p>Agotado</p>";
    }

    if ($producto['precio'] > 10) {
        echo "<p>Producto principal</p>";
    } else {
        echo "<p>Producto complemento</p>";
    }

    echo "</div>";
}
```

Refactoriza el código creando al menos estas funciones:

- `formatear_precio(float $precio): string`
- `obtener_mensaje_stock(int $stock): string`
- `obtener_tipo_producto(float $precio): string`
- `renderizar_producto(array $producto): string`

Condiciones:

- El `foreach` principal debe quedar lo más limpio posible.
- Intenta que dentro del bucle solo haya una llamada a `renderizar_producto()`.
- Evita mezclar toda la lógica directamente con `echo`.
- Prioriza `return` en las funciones.
- El HTML final debe ser equivalente, pero el código debe ser más legible.

Objetivo:

- Detectar código repetido o demasiado mezclado.
- Aprender a refactorizar sin cambiar el resultado final.
- Entender por qué las funciones ayudan tanto en themes, templates y plugins.

---

## Extra opcional

A partir de cualquiera de los ejercicios anteriores, crea un archivo `05-funciones-helpers.php` y mueve allí las funciones reutilizables.

Después:

- Incluye el archivo con `require_once`.
- Reutiliza las funciones en dos ejercicios distintos.
- Comprueba que no duplicas código.

---