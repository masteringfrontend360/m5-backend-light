<!-- 
## **6. Aviso de carrito vacío**

Crea una sección del carrito que muestre un mensaje apropiado según el contenido. Tienes estos datos:

```php
$carrito = [
    ['nombre' => 'Camiseta', 'precio' => 19.99, 'cantidad' => 2],
    ['nombre' => 'Pantalón', 'precio' => 39.99, 'cantidad' => 1]
];
// o también puede estar vacío: $carrito = [];
```

**¿Qué mostrar?**

- Si está vacío: "Tu carrito está vacío 😔"
- Si tiene productos: "Tienes X productos en el carrito"

**💡 Pensar:**

1. ¿Cuántos elementos tiene realmente un array vacío?
2. ¿`empty($carrito)` te dice la verdad completa?
3. ¿Qué pasa si usas count() vs si usas if (!$carrito)?
4. ¿Te animas con sintaxis alternativa para meter el HTML?

--- -->