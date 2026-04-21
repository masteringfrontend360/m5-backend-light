<?php
declare(strict_types=1);

$posts = [
    [
        'titulo' => 'PHP funciones útiles',
        'fecha' => '2024-02-23',
        'categorias' => ['php', 'backend'],
        'destacado' => false,
    ],
    [
        'titulo' => 'WordPress para frontenders',
        'fecha' => '2024-03-01',
        'categorias' => ['wordpress', 'frontend'],
        'destacado' => false,
    ],
    [
        'titulo' => '  WooCommerce avanzado  ',
        'fecha' => '2024-02-05',
        'categorias' => ['php'],
        'destacado' => true,
    ],
    [
        'titulo' => 'AJAX con PHP',
        'fecha' => '2024-02-01',
        'categorias' => ['ajax', 'javascript'],
        'destacado' => false,
    ],
];

/**
 * Escape seguro para salida HTML
 */
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Limpia espacios sobrantes internos y externos
 */
function limpiarTexto(string $texto): string
{
    $texto = trim($texto);
    return preg_replace('/\s+/', ' ', $texto) ?? '';
}

/**
 * Formatea un título sin forzar minúsculas globales
 */
function formatearTitulo(string $titulo): string
{
    $titulo = limpiarTexto($titulo);
    return mb_convert_case($titulo, MB_CASE_TITLE, 'UTF-8');
}

/**
 * Intenta crear una fecha válida desde Y-m-d
 */
function crearFechaDesdeYmd(string $fecha): ?DateTimeImmutable
{
    $fechaObj = DateTimeImmutable::createFromFormat('Y-m-d', $fecha);

    if (!$fechaObj) {
        return null;
    }

    $errores = DateTimeImmutable::getLastErrors();

    if (($errores['warning_count'] ?? 0) > 0 || ($errores['error_count'] ?? 0) > 0) {
        return null;
    }

    return $fechaObj;
}

/**
 * Convierte categorías técnicas en etiquetas visibles
 */
function formatearCategorias(array $categorias): array
{
    return array_map(
        fn(string $categoria): string => mb_convert_case(limpiarTexto($categoria), MB_CASE_TITLE, 'UTF-8'),
        $categorias
    );
}

/**
 * Obtiene todas las categorías permitidas a partir de los posts
 */
function obtenerCategoriasPermitidas(array $posts): array
{
    $categorias = [];

    foreach ($posts as $post) {
        foreach ($post['categorias'] as $categoria) {
            $categorias[] = mb_strtolower(limpiarTexto($categoria), 'UTF-8');
        }
    }

    $categorias = array_unique($categorias);
    sort($categorias);

    return $categorias;
}

$categoriasPermitidas = obtenerCategoriasPermitidas($posts);

$categoria = filter_input(INPUT_GET, 'cat', FILTER_DEFAULT);
$categoria = is_string($categoria) ? mb_strtolower(limpiarTexto($categoria), 'UTF-8') : '';

if ($categoria !== '' && !in_array($categoria, $categoriasPermitidas, true)) {
    $categoria = '';
}

$postsRes = array_filter(
    $posts,
    fn(array $post): bool => $categoria === '' || in_array($categoria, $post['categorias'], true)
);

usort($postsRes, function (array $a, array $b): int {
    if (($a['destacado'] ?? false) !== ($b['destacado'] ?? false)) {
        return ($b['destacado'] ?? false) <=> ($a['destacado'] ?? false);
    }

    return strcmp($b['fecha'], $a['fecha']);
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
            line-height: 1.5;
        }
        .filtro-activo {
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            background: #f4f4f4;
            border-left: 4px solid #333;
        }
        .post-card {
            border: 1px solid #ddd;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        .badge-destacado {
            display: inline-block;
            margin-top: 0.5rem;
            font-weight: bold;
            color: #8a5a00;
        }
        .categorias {
            margin-top: 0.5rem;
            color: #555;
        }
        .sin-resultados {
            padding: 1rem;
            background: #fff8e1;
            border: 1px solid #f0d98a;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>Blog de desarrollo</h1>
</header>

<main>
    <?php if ($categoria !== ''): ?>
        <p class="filtro-activo">
            Filtrando por categoría: <strong><?php echo e(mb_convert_case($categoria, MB_CASE_TITLE, 'UTF-8')); ?></strong>
        </p>
    <?php endif; ?>

    <?php if (empty($postsRes)): ?>
        <p class="sin-resultados">No hay publicaciones para esa categoría.</p>
    <?php else: ?>
        <?php foreach ($postsRes as $post): ?>
            <?php
                $tituloFormateado = formatearTitulo($post['titulo']);
                $fechaObj = crearFechaDesdeYmd($post['fecha']);
                $fechaOriginal = $fechaObj ? $fechaObj->format('Y-m-d') : '';
                $fechaFormateada = $fechaObj ? $fechaObj->format('d/m/Y') : 'Fecha no disponible';
                $categoriasVisibles = formatearCategorias($post['categorias']);
                $esDestacado = (bool) ($post['destacado'] ?? false);
            ?>
            <article class="post-card">
                <h2><?php echo e($tituloFormateado); ?></h2>

                <?php if ($fechaObj): ?>
                    <time datetime="<?php echo e($fechaOriginal); ?>">
                        <?php echo e($fechaFormateada); ?>
                    </time>
                <?php else: ?>
                    <p><?php echo e($fechaFormateada); ?></p>
                <?php endif; ?>

                <?php if ($esDestacado): ?>
                    <p><span class="badge-destacado">⭐ Destacado</span></p>
                <?php endif; ?>

                <div class="categorias">
                    <?php echo e(implode(', ', $categoriasVisibles)); ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

</body>
</html>