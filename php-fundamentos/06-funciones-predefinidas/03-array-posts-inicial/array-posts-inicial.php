## Ejercicio 3: Listado posts WordPress mejorado

### Nivel
Avanzado - Refuerza `date()`, `gettype()`, `in_array()`, `ucfirst()`, `str_replace()`.

### Enunciado

En `php-fundamentos/funciones-predefinidas/posts-wp/` simula `single.php` de WordPress procesando un listado de posts.

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
_ `?cat=php` → solo posts con categoría 'php'  
_ Sin parámetro → todos los posts

#### 3. Procesar cada post

**Para cada post del array, debes:**

_ **Limpiar título:** `ucfirst(strtolower(trim($post['titulo'])))`  
_ **Formatear fecha:** `date('d/m/Y', strtotime($post['fecha']))` (convierte timestamp o string)  
_ **Debug tipo fecha:** Usa `gettype($post['fecha'])` para mostrar el tipo  
_ **Badge especial:** Si `in_array('destacado', $post['categorias'])` → mostrar badge ⭐  
_ **Limpiar categorías:** `str_replace()` para cambiar 'backend' por 'Backend'

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

_ **Convertir fecha:**  
```php
$timestamp = strtotime($post['fecha']);
$fechaFormateada = date('d/m/Y', $timestamp);
```

_ **Filtrar por categoría:**  
```php
$postsFiltrados = [];
foreach ($posts as $post) {
    if (empty($_GET['cat']) || in_array($_GET['cat'], $post['categorias'])) {
        $postsFiltrados[] = $post;
    }
}
```

_ **Limpiar categorías:**  
```php
foreach ($post['categorias'] as &$cat) {
    $cat = str_replace('backend', 'Backend', $cat);
}
```

### Pruebas recomendadas

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

### Qué NO hacer

❌ No uses bucles `for` (usa `foreach`).  
❌ No crees funciones propias.  
❌ No uses `filter()` (no visto aún).  
❌ No hardcodees las fechas (deben procesarse dinámicamente).  