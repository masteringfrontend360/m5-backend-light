<!-- ## **7. Tabla de productos**

Recorre el carrito y genera una tabla HTML con columnas: Producto | Cantidad | Precio unit. | Subtotal.

```php
$productos = [
    ['nombre' => 'Camiseta', 'cantidad' => 2, 'precio' => 19.99],
    ['nombre' => 'Pantalón', 'cantidad' => 1, 'precio' => 39.99],
    ['nombre' => 'Calcetines', 'cantidad' => 3, 'precio' => 5.99]
];
```

**💡Pensar:**

1. ¿Qué dos formas tiene foreach para recorrer arrays asociativos?
2. ¿Cómo calculas subtotal = cantidad × precio?
3. ¿number_format() te ayuda con los decimales?
4. Mira si puedes usar sintaxis alternativa: foreach: endforeach;
5. ¿Qué pasa si usas &$producto? ¿Cambiarías algo del array? -->