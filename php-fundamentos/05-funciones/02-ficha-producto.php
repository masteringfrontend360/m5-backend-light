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