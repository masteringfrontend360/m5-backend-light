## Ejercicio 2: Carrito WooCommerce dinámico

### Nivel
Intermedio - Refuerza `count()`, `array_push()`, `array_pop()`, `implode()`, `number_format()`.

### Enunciado

En `php-fundamentos/funciones-predefinidas/10-carrito-woo/` crea `carrito.php` que simule un carrito de WooCommerce.

#### 1. Carrito inicial

Parte de este array de productos:

```php
$carrito = [
    ['nombre' => 'Camiseta', 'precio' => 19.95],
    ['nombre' => 'Pantalón', 'precio' => 39.50]
];
```

#### 2. Parámetros GET

Tu archivo `carrito.php` debe responder a estas acciones por URL:

_ `?accion=anadir&producto=Calcetines&precio=12.50`  
_ `?accion=quitar`  
_ `?accion=ver`

#### 3. Funciones de carrito

_ **Añadir producto:** `array_push($carrito, $nuevoProducto)`  
_ **Quitar último:** `array_pop($carrito)`  
_ **Contar productos:** `count($carrito)`  
_ **Calcular total:** Suma precios con `array_reduce()`  
_ **Mostrar lista:** `implode()` para lista + `number_format()` para precios  

#### 4. Salida esperada

Muestra una salida HTML con un formato similar al de WooCommerce:

```text
Productos (2): Camiseta €19,95 | Pantalón €39,50
TOTAL: €59,45
```
### Pruebas recomendadas

_ Abre `carrito.php` → debe mostrar carrito inicial con 2 productos.  
_ `?accion=anadir&producto=Calcetines&precio=12.50` → 3 productos, total actualizado.  
_ `?accion=quitar` → vuelve a 2 productos.  
_ Prueba precio inválido → no añade producto.

### Funciones que debes usar

_ `count()` - Número de productos  
_ `array_push()` - Añadir producto  
_ `array_pop()` - Quitar último  
_ `implode()` - Lista de productos  
_ `number_format()` - Formatear precios  
_ `filter_var()` - Validar precio numérico  
