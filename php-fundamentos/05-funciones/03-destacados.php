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