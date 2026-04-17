<?php
$posts = [
    ['titulo' => 'PHP funciones útiles', 'fecha' => '2024-02-23', 'categorias' => ['php', 'backend']],
    ['titulo' => 'WordPress para frontenders', 'fecha' => '2024-03-01', 'categorias' => ['wordpress', 'frontend']],
    ['titulo' => '  WooCommerce avanzado  ', 'fecha' => '2024-02-05', 'categorias' => ['php', 'destacado']],
    ['titulo' => 'AJAX con PHP', 'fecha' => '2024-02-01', 'categorias' => ['ajax', 'javascript']]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
    $categoria = $_GET['cat'] ?? '';

/* si hay categoría, filtra; si no, muestra todo”
*/
if (!empty($categoria)){
   $postsRes = [];
   foreach ($posts as $post){
    if(in_array($categoria, $post['categorias'])){
        array_push($postsRes, $post);
    }
   }
}else{
    $postsRes = $posts;
}

    foreach ($postsRes as $post):
        $tituloFormateado = ucfirst(strtolower(trim($post['titulo'])));
        $fechaOriginal = date('Y-m-d', strtotime($post['fecha']));
        $fechaFormateada = date('d/m/Y', strtotime($post['fecha']));
        $categoriasMay = array_map ('ucfirst', $post['categorias']);
?>
<article class="post-card">
    <h2><?php echo $tituloFormateado;  ?></h2>
    <time datetime="<?php echo $fechaOriginal; ?>"><?php echo $fechaFormateada; ?></time>
    <!-- <span>Tipo fecha: <?php //echo gettype($post['fecha']); ?></span> -->
    <?php if (in_array('destacado', $post['categorias'])): ?>
        <span class="badge-destacado">⭐ Destacado</span>
    <?php endif; ?>
    <div class="categorias">
        <?php echo implode(', ', $categoriasMay); ?>
    </div>
</article>
<?php
    endforeach;
?>

</body>
</html>