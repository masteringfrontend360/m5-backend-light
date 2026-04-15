<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Array inicial de posts
$posts = [
    ['titulo' => 'PHP funciones útiles', 'fecha' => 1698796800, 'categorias' => ['php', 'backend']],
    ['titulo' => 'WordPress para frontenders', 'fecha' => 1704067200, 'categorias' => ['wordpress', 'frontend']],
    ['titulo' => '  WooCommerce avanzado  ', 'fecha' => 1706668800, 'categorias' => ['php', 'destacado']],
    ['titulo' => 'AJAX con PHP', 'fecha' => '2024-02-01', 'categorias' => ['ajax', 'javascript']]
];

$categoriaFiltro = trim($_GET['cat'] ?? '');

// Filtrar posts
$postsFiltrados = [];

foreach ($posts as $post) {
    if ($categoriaFiltro === '' || in_array($categoriaFiltro, $post['categorias'])) {
        $postsFiltrados[] = $post;
    }
}

$totalPosts = count($postsFiltrados);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado posts WordPress mejorado</title>

<style>
body {
    font-family: Arial;
    margin: 40px;
    background: #f4f4f4;
}

.box {
    background: white;
    padding: 24px;
    border-radius: 10px;
    max-width: 1000px;
}

.intro {
    background: #eef4ff;
    border-left: 4px solid #2271b1;
    padding: 14px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.filtro {
    background: #fff8e5;
    border-left: 4px solid #dba617;
    padding: 14px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.post {
    background: #f9f9f9;
    border-left: 4px solid #7e8993;
    padding: 16px;
    margin-bottom: 16px;
    border-radius: 6px;
}

.badge {
    display: inline-block;
    background: #d63638;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    margin-top: 8px;
}

.tag {
    display: inline-block;
    background: #2271b1;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    margin-right: 5px;
    margin-top: 6px;
}

.debug {
    background: #fff8e5;
    padding: 8px;
    border-radius: 6px;
    margin-top: 10px;
}

a {
    background: #0073aa;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    margin-right: 6px;
}

a:hover {
    background: #005f8d;
}
</style>

</head>
<body>

<div class="box">

<h1>Ejercicio 03 · Listado posts WordPress</h1>

<div class="intro">
    <p><strong>Objetivo:</strong> simular un loop de WordPress con limpieza, formato y filtrado.</p>
</div>

<div class="filtro">
    <strong>Filtro:</strong>
    <?php echo $categoriaFiltro === '' ? 'Todos' : $categoriaFiltro; ?>
    <br><br>

    <a href="?">Todos</a>
    <a href="?cat=php">PHP</a>
    <a href="?cat=wordpress">WordPress</a>
    <a href="?cat=ajax">AJAX</a>
</div>

<p><strong>Total posts:</strong> <?php echo $totalPosts; ?></p>

<?php if ($totalPosts === 0): ?>

    <p>No hay resultados.</p>

<?php else: ?>

    <?php foreach ($postsFiltrados as $post): ?>

        <?php
        // 🔹 Título (sin romper siglas)
        $titulo = ucfirst(trim($post['titulo']));

        // 🔹 Fecha limpia
        if (is_int($post['fecha'])) {
            $timestamp = $post['fecha'];
        } else {
            $timestamp = strtotime($post['fecha']);
        }

        $fechaFormateada = date('d/m/Y', $timestamp);

        // 🔹 Categorías limpias
        $categoriasLimpias = [];

        foreach ($post['categorias'] as $cat) {
            $cat = str_replace('backend', 'Backend', $cat);
            $cat = str_replace('frontend', 'Frontend', $cat);
            $cat = str_replace('wordpress', 'WordPress', $cat);
            $cat = str_replace('php', 'PHP', $cat);
            $cat = str_replace('ajax', 'AJAX', $cat);
            $cat = str_replace('javascript', 'JavaScript', $cat);
            $cat = str_replace('destacado', 'Destacado', $cat);
            $categoriasLimpias[] = $cat;
        }
        ?>

        <div class="post">

            <h2><?php echo $titulo; ?></h2>

            <p><strong>Fecha:</strong> <?php echo $fechaFormateada; ?></p>

            <div class="debug">
                Tipo fecha: <?php echo gettype($post['fecha']); ?>
            </div>

            <?php if (in_array('destacado', $post['categorias'])): ?>
                <div class="badge">⭐ Destacado</div>
            <?php endif; ?>

            <div>
                <?php foreach ($categoriasLimpias as $cat): ?>
                    <span class="tag"><?php echo $cat; ?></span>
                <?php endforeach; ?>
            </div>

        </div>

    <?php endforeach; ?>

<?php endif; ?>

</div>

</body>
</html>