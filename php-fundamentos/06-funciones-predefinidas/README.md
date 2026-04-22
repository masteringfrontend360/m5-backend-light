# Prácticas: Funciones predefinidas

## Ejercicio 1: Procesador de comentarios WordPress

### Nivel
Básico - Refuerza `trim()`, `htmlspecialchars()`, `strlen()` y `empty()`.

### Enunciado

Crea un fichero `procesar-comentario.php` en `php-fundamentos/funciones-predefinidas/10-comentarios-wp/` que:

#### 1. Reciba datos de formulario
<<<<<<< HEAD
- `$_POST['nombre']`  
- `$_POST['email']`  
- `$_POST['comentario']`
=======
_ `$_POST['nombre']`  
_ `$_POST['email']`  
_ `$_POST['comentario']`
>>>>>>> origin/delia

#### 2. Aplique limpieza básica

```php
$nombreLimpio = trim(htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8'));
$emailLimpio = trim(strtolower(htmlspecialchars($_POST['email'] ?? '')));
$comentarioLimpio = trim(htmlspecialchars($_POST['comentario'] ?? ''));
```

#### 3. Valide longitud
<<<<<<< HEAD
- Nombre: 2-50 caracteres (`strlen($nombreLimpio)` debe estar entre 2 y 50)  
- Email: 5-100 caracteres  
- Comentario: 10-500 caracteres  
=======
_ Nombre: 2-50 caracteres (`strlen($nombreLimpio)` debe estar entre 2 y 50)  
_ Email: 5-100 caracteres  
_ Comentario: 10-500 caracteres  
>>>>>>> origin/delia

Si alguna validación falla, muestra un mensaje de error específico y no procesa el comentario.

#### 4. Muestre resultado formateado como comentario WordPress

Si todas las validaciones pasan, muestra:

```php
<div class="comentario-wp">
    <strong><?php echo ucfirst($nombreLimpio); ?></strong>
    <em><?php echo $emailLimpio; ?></em>
    <p><?php echo $comentarioLimpio; ?></p>
</div>
```

### form-comentario.html

```html
<!DOCTYPE html>
<html>
<head>
    <title>Prueba comentarios WP</title>
    <style>
        .comentario-wp { 
            border-left: 4px solid #0073aa; 
            padding: 1rem; 
            margin: 1rem 0; 
            background: #f9f9f9; 
        }
    </style>
</head>
<body>
    <h1>Prueba procesador de comentarios</h1>
    <form method="POST" action="procesar-comentario.php">
        <p>
            <label>Nombre: <input name="nombre" required></label>
        </p>
        <p>
            <label>Email: <input name="email" type="email" required></label>
        </p>
        <p>
            <label>Comentario: 
                <textarea name="comentario" rows="4" required></textarea>
            </label>
        </p>
        <button type="submit">Publicar comentario</button>
    </form>
</body>
</html>
```

### Pruebas recomendadas

<<<<<<< HEAD
- **Datos válidos:** `Ana García`, `ana@ejemplo.com`, comentario de 20 caracteres.  
- **Nombre corto:** `A` (debe fallar).  
- **Nombre largo:** 60 caracteres (debe fallar).  
- **Email sin arroba:** `ana.ejemplo.com` (debe fallar).  
- **Espacios extra:** `"  Ana  "`, `"ANA@EMAIL.COM"` (debe limpiarse correctamente).  

### Funciones que debes usar

- `trim()` - Quitar espacios  
- `htmlspecialchars()` - Sanitizar HTML  
- `strlen()` - Validar longitud  
- `empty()` - Comprobar campos vacíos  
- `ucfirst()` - Formatear nombre  
- `strtolower()` - Normalizar email  
=======
_ **Datos válidos:** `Ana García`, `ana@ejemplo.com`, comentario de 20 caracteres.  
_ **Nombre corto:** `A` (debe fallar).  
_ **Nombre largo:** 60 caracteres (debe fallar).  
_ **Email sin arroba:** `ana.ejemplo.com` (debe fallar).  
_ **Espacios extra:** `"  Ana  "`, `"ANA@EMAIL.COM"` (debe limpiarse correctamente).  

### Funciones que debes usar

_ `trim()` - Quitar espacios  
_ `htmlspecialchars()` - Sanitizar HTML  
_ `strlen()` - Validar longitud  
_ `empty()` - Comprobar campos vacíos  
_ `ucfirst()` - Formatear nombre  
_ `strtolower()` - Normalizar email  
>>>>>>> origin/delia

---

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

<<<<<<< HEAD
- `?accion=anadir&producto=Calcetines&precio=12.50`  
- `?accion=quitar`  
- `?accion=ver`

#### 3. Funciones de carrito

- **Añadir producto:** `array_push($carrito, $nuevoProducto)`  
- **Quitar último:** `array_pop($carrito)`  
- **Contar productos:** `count($carrito)`  
- **Calcular total:** Suma precios con `array_reduce()`  
- **Mostrar lista:** `implode()` para lista + `number_format()` para precios  
=======
_ `?accion=anadir&producto=Calcetines&precio=12.50`  
_ `?accion=quitar`  
_ `?accion=ver`

#### 3. Funciones de carrito

_ **Añadir producto:** `array_push($carrito, $nuevoProducto)`  
_ **Quitar último:** `array_pop($carrito)`  
_ **Contar productos:** `count($carrito)`  
_ **Calcular total:** Suma precios con `array_reduce()`  
_ **Mostrar lista:** `implode()` para lista + `number_format()` para precios  
>>>>>>> origin/delia

#### 4. Salida esperada

Muestra una salida HTML con un formato similar al de WooCommerce:

```text
Productos (2): Camiseta €19,95 | Pantalón €39,50
TOTAL: €59,45
```
### Pruebas recomendadas

<<<<<<< HEAD
- Abre `carrito.php` → debe mostrar carrito inicial con 2 productos.  
- `?accion=anadir&producto=Calcetines&precio=12.50` → 3 productos, total actualizado.  
- `?accion=quitar` → vuelve a 2 productos.  
- Prueba precio inválido → no añade producto.

### Funciones que debes usar

- `count()` - Número de productos  
- `array_push()` - Añadir producto  
- `array_pop()` - Quitar último  
- `implode()` - Lista de productos  
- `number_format()` - Formatear precios  
- `filter_var()` - Validar precio numérico  
=======
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
>>>>>>> origin/delia

## Ejercicio 3: Listado posts WordPress mejorado

### Nivel
Avanzado - Refuerza `date()`, `gettype()`, `in_array()`, `ucfirst()`, `str_replace()`.

<<<<<<< HEAD
### Enunciado

En `php-fundamentos/funciones-predefinidas/posts-wp/` simula `single.php` de WordPress procesando un listado de posts.

=======
>>>>>>> origin/delia
#### 1. Array posts inicial

Parte de este array simulado de posts:

```php
$posts = [
    ['titulo' => 'PHP funciones útiles', 'fecha' => 1698796800, 'categorias' => ['php', 'backend']],
    ['titulo' => 'WordPress para frontenders', 'fecha' => 1704067200, 'categorias' => ['wordpress', 'frontend']],
    ['titulo' => '  WooCommerce avanzado  ', 'fecha' => 1706668800, 'categorias' => ['php', 'destacado']],
    ['titulo' => 'AJAX con PHP', 'fecha' => '2024-02-01', 'categorias' => ['ajax', 'javascript']]
];
```

#### 2. Parámetros GET

Debe filtrar por categoría con `$_GET['cat']`:
<<<<<<< HEAD
- `?cat=php` → solo posts con categoría 'php'  
- Sin parámetro → todos los posts
=======
`?cat=php` → solo posts con categoría 'php'  
_ Sin parámetro → todos los posts
>>>>>>> origin/delia

#### 3. Procesar cada post

**Para cada post del array, debes:**

<<<<<<< HEAD
- **Limpiar título:** `ucfirst(strtolower(trim($post['titulo'])))`  
- **Formatear fecha:** `date('d/m/Y', strtotime($post['fecha']))` (convierte timestamp o string)  
- **Debug tipo fecha:** Usa `gettype($post['fecha'])` para mostrar el tipo  
- **Badge especial:** Si `in_array('destacado', $post['categorias'])` → mostrar badge ⭐  
- **Limpiar categorías:** `str_replace()` para cambiar 'backend' por 'Backend'
=======
_ **Limpiar título:** `ucfirst(strtolower(trim($post['titulo'])))`  
_ **Formatear fecha:** `date('d/m/Y', strtotime($post['fecha']))` (convierte timestamp o string)  
_ **Debug tipo fecha:** Usa `gettype($post['fecha'])` para mostrar el tipo  
_ **Badge especial:** Si `in_array('destacado', $post['categorias'])` → mostrar badge ⭐  
_ **Limpiar categorías:** `str_replace()` para cambiar 'backend' por 'Backend'
>>>>>>> origin/delia

#### 4. Salida HTML como loop WordPress

```php
<article class="post-card">
    <h2><?php echo $tituloFormateado; ?></h2>
    <time datetime="<?php echo $fechaOriginal; ?>"><?php echo $fechaFormateada; ?></time>
    <span>Tipo fecha: <?php echo gettype($post['fecha']); ?></span>
    <?php if (in_array('destacado', $post['categorias'])): ?>
        <span class="badge-destacado">⭐ Destacado</span>
    <?php endif; ?>
    <div class="categorias">
        <?php echo implode(', ', $categoriasLimpias); ?>
    </div>
</article>
```

### Pistas (NO copies este código)

<<<<<<< HEAD
- **Convertir fecha:**  
=======
_ **Convertir fecha:**  
>>>>>>> origin/delia
```php
$timestamp = strtotime($post['fecha']);
$fechaFormateada = date('d/m/Y', $timestamp);
```

<<<<<<< HEAD
- **Filtrar por categoría:**  
=======
_ **Filtrar por categoría:**  
>>>>>>> origin/delia
```php
$postsFiltrados = [];
foreach ($posts as $post) {
    if (empty($_GET['cat']) || in_array($_GET['cat'], $post['categorias'])) {
        $postsFiltrados[] = $post;
    }
}
```

<<<<<<< HEAD
- **Limpiar categorías:**  
=======
_ **Limpiar categorías:**  
>>>>>>> origin/delia
```php
foreach ($post['categorias'] as &$cat) {
    $cat = str_replace('backend', 'Backend', $cat);
}
```

### Pruebas recomendadas

<<<<<<< HEAD
- Abre `posts-wp.php` → muestra los 4 posts formateados.  
- `?cat=php` → solo 2 posts (PHP funciones + WooCommerce).  
- Verifica que títulos tengan primera letra mayúscula y espacios quitados.  
- Verifica que fechas estén en formato `dd/mm/yyyy`.  
- El post de WooCommerce debe mostrar badge ⭐.  
- Debug debe mostrar tipos `string` o `integer` según la fecha.

### Funciones que debes usar

- `date()` - Formatear fecha legible  
- `gettype()` - Debug tipo de datos fecha  
- `in_array()` - Detectar posts destacados  
- `ucfirst()` - Primera letra del título  
- `str_replace()` - Limpiar nombres de categorías  
- `strtotime()` - Convertir fechas a timestamp  
- `trim()` - Limpiar títulos  
=======
_ Abre `posts-wp.php` → muestra los 4 posts formateados.  
_ `?cat=php` → solo 2 posts (PHP funciones + WooCommerce).  
_ Verifica que títulos tengan primera letra mayúscula y espacios quitados.  
_ Verifica que fechas estén en formato `dd/mm/yyyy`.  
_ El post de WooCommerce debe mostrar badge ⭐.  
_ Debug debe mostrar tipos `string` o `integer` según la fecha.

### Funciones que debes usar

_ `date()` - Formatear fecha legible  
_ `gettype()` - Debug tipo de datos fecha  
_ `in_array()` - Detectar posts destacados  
_ `ucfirst()` - Primera letra del título  
_ `str_replace()` - Limpiar nombres de categorías  
_ `strtotime()` - Convertir fechas a timestamp  
_ `trim()` - Limpiar títulos  
>>>>>>> origin/delia

### Qué NO hacer

❌ No uses bucles `for` (usa `foreach`).  
❌ No crees funciones propias.  
❌ No uses `filter()` (no visto aún).  
❌ No hardcodees las fechas (deben procesarse dinámicamente).  