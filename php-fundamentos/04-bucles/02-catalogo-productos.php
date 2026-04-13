<!-- ## **Ejercicio 2: Catálogo de productos (25-30 min)**

**Objetivo:** Array multidimensional + ordenación + mostrar en HTML.

**Enunciado:**

Crea un array `$productos` con 4 productos (cada uno con `nombre`, `precio`, `stock`, `foto` como URL placeholder tipo `https://via.placeholder.com/200x150?text=Producto`).

Muéstralos en tarjetas HTML.

Añade un `<select>` para ordenar por precio (asc/desc). Al enviar, reordena con `asort()` o `arsort()` y muestra el catálogo ordenado.

**💡 Pistas:**

1. Estructura: `$productos = [ ['nombre'=>'Camiseta', 'precio'=>19.95, 'stock'=>10, 'foto'=>'url'], ... ];`
2. Tarjeta HTML: `<div class="producto"><img src="..."> <h3>...</h3> <p>€...</p></div>`.
3. Ordena con `if ($_POST['orden'] == 'asc') asort($productos);` (usa clave `'precio'`).
4. Este array es lo que devuelve `wc_get_products()`. 
Transición:
**$productos = [ ... ];  →  $productos = wc_get_products(['limit'=>4]);**
5. **¡Prueba!** Usa `print_r($productos);` para depurar antes de mostrar.

--- -->
<?php
$productos = [
    [
    'nombre'=>'Camiseta', 
    'precio'=>19.95, 
    'stock'=>10, 
    'foto'=>'https://placehold.co/200x300?text=Camiseta'
    ],
    [
    'nombre'=>'Pantalón', 
     'precio'=>39.95, 
     'stock'=>5, 
     'foto'=>'https://placehold.co/200x300?text=Pantalón'
     ],
    [
        'nombre'=>'Zapatillas',
         'precio'=>59.95, 
         'stock'=>3, 
         'foto'=>'https://placehold.co/200x300?text=Zapatillas'],
    [
        'nombre'=>'Gorra', 
        'precio'=>14.95, 
        'stock'=>20, 
        'foto'=>'https://placehold.co/200x300?text=Gorra'
        ]
];
// echo '<prep>';
// var_dump($productos);
// echo '<pre>';

// 3. Ordena con `if ($_POST['orden'] == 'asc') asort($productos);` (usa clave `'precio'`).
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orden = $_POST['orden'] ?? '';
    $selected = '';
    usort($productos, function($a, $b) use ($orden) {
        if ($orden === 'asc') {
            return $a['precio'] <=> $b['precio'];
        } else {
            return $b['precio'] <=> $a['precio'];
        }
    });
  }

?>
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Añade un `<select>` para ordenar por precio (asc/desc). Al enviar, reordena con `asort()` o `arsort()` y muestra el catálogo ordenado. -->
    <form method="post">
        <label for="orden">Ordenar por precio:</label>
        <select name="orden" id="orden">
            <option value="asc" selected>Ascendente</option>
            <option value="desc">Descendente</option>
        </select>
        <button type="submit">Ordenar</button>
    </form>
     <!-- 2. Tarjeta HTML: `<div class="producto"><img src="..."> <h3>...</h3> <p>€...</p></div>`.  -->
        <?php foreach($productos as $producto): ?>
            <div class="producto">
                <img src="<?php echo htmlspecialchars($producto['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p>€<?php echo number_format($producto['precio'], 2); ?></p>
            </div>
        <?php endforeach; ?>
</body>
</html>