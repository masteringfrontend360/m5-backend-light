# Prácticas: 09-funciones

En esta práctica vamos a usar funciones en PHP para reutilizar lógica, limpiar plantillas y preparar mejor código orientado a WordPress y WooCommerce.

La idea no es hacer ejercicios abstractos, sino resolver pequeños casos reales de catálogo, fichas de producto y refactorización.

## Ejercicio 1: Procesador de productos

Crea un archivo `01-procesador-productos.php`.

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

---

## Ejercicio 2: Ficha de producto estilo WooCommerce

Crea un archivo `02-ficha-producto.php`.

Dispones de este producto:

```php
<?php

$producto = [
    'nombre' => 'Pack tienda online',
    'precio' => 49.95,
    'descuento' => 0.15,
    'stock' => 6,
    'envio_gratis' => true,
    'valoracion' => 4.6,
];
```

Crea las siguientes funciones:

- `calcular_precio_rebajado(float $precio, float $descuento): float`
- `mostrar_badge_descuento(float $descuento): string`
- `mostrar_badge_envio(bool $envioGratis): string`
- `formatear_valoracion(float $valoracion): string`
- `renderizar_ficha_producto(array $producto): string`

Condiciones:

- `calcular_precio_rebajado()` debe devolver el precio final tras aplicar el descuento.
- `mostrar_badge_descuento()` debe devolver un `<span>` con el porcentaje de descuento solo si el descuento es mayor que 0.
- `mostrar_badge_envio()` debe devolver `Envío gratis` solo si corresponde.
- `formatear_valoracion()` debe devolver un texto tipo `4.6 / 5`.
- `renderizar_ficha_producto()` debe construir una ficha HTML completa usando el resto de funciones.
- Muestra precio original y precio rebajado.

Objetivo:

- Componer funciones entre sí.
- Ver cómo una función grande puede apoyarse en varias pequeñas.
- Acercar el ejercicio a una ficha real de producto.

---

## Ejercicio 3: Mini listado de productos destacados

Crea un archivo `03-destacados.php`.

Dispones de este array:

```php
<?php

$productos = [
    ['nombre' => 'Plugin SEO', 'precio' => 29.99, 'destacado' => true, 'stock' => 12],
    ['nombre' => 'Tema corporativo', 'precio' => 59.00, 'destacado' => false, 'stock' => 4],
    ['nombre' => 'Pack formularios', 'precio' => 18.50, 'destacado' => true, 'stock' => 0],
    ['nombre' => 'Módulo reservas', 'precio' => 80.00, 'destacado' => true, 'stock' => 7],
];
```

Crea las siguientes funciones:

- `es_producto_visible(array $producto): bool`
- `generar_etiqueta_stock(int $stock): string`
- `renderizar_tarjeta_destacada(array $producto): string`
- `renderizar_listado_destacados(array $productos): string`

Condiciones:

- Solo deben mostrarse productos marcados como destacados.
- `es_producto_visible()` debe decidir si el producto se pinta o no.
- `generar_etiqueta_stock()` debe devolver una etiqueta breve:
    - `Disponible`
    - `Últimas unidades`
    - `Agotado`
- `renderizar_tarjeta_destacada()` debe devolver una tarjeta HTML por producto.
- `renderizar_listado_destacados()` debe recorrer todos los productos y devolver el bloque completo.

Objetivo:

- Trabajar funciones que reciben arrays.
- Separar filtrado, transformación y render.
- Simular un bloque de destacados para home o archivo de tienda.

---

## Ejercicio 4: Refactorización de plantilla de tienda

Crea un archivo `04-refactorizar-tienda.php`.

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