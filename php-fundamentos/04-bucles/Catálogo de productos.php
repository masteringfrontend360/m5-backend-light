<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Array multidimensional + ordenación + mostrar en HTML.</title>
</head>

<body>
<form method="GET">
    <label>
            Orden por precio:
        </label>
    <select name="orden">
        <option value="">Ordenar por precio</option>
        <option value="asc">Ascendiente</option>
        <option value="desc">Descendiente</option>
    </select>
    <button type="submit">Ordenar</button>
</form>

    <?php
    // Crea un array $productos con 4 productos (cada uno con nombre, precio, stock, foto como URL placeholder tipo https://placehold.co/200x150?text=Producto.
    $productos = [
        [
            'nombre' => 'Air Jordan 1 Retro High OG',
            'precio' => 179.99,
            'stock' => 3,
            'foto' => 'https://placehold.co/200x150?text=Air+Jordan+1+Retro+High+OG'
        ],
        [
            'nombre' => 'Air Jordan 1 Low',
            'precio' => 129.99,
            'stock' => 6,
            'foto' => 'https://placehold.co/200x150?text=Air+Jordan+1+Low'
        ],
        [
            'nombre' => 'Jordan Spizike Low',
            'precio' => 124.99,
            'stock' => 1,
            'foto' => 'https://placehold.co/200x150?text=Jordan+Spizike+Low'
        ],
        [
            'nombre' => 'Air Jordan 4 Retro "Flight Club"',
            'precio' => 209.99,
            'stock' => 10,
            'foto' => 'https://placehold.co/200x150?text=Air+Jordan+4+Retro+"Flight+Club"'
        ],
    ];

    


    // Añade un <select> para ordenar por precio (asc/desc). Al enviar, reordena con asort() o arsort() y muestra el catálogo ordenado.
    if ($_GET["orden"] === "asc") {
        usort($productos, function ($a, $b) {
            return $a["precio"] - $b["precio"];
        });
    } elseif ($_GET["orden"] === "desc") {

        usort($productos, function ($a, $b) {
            return $b["precio"] - $a["precio"];
        });
    }

    // Muéstralos en tarjetas HTML.
    foreach ($productos as $valor) {
        echo "
        <div class='producto'>
            <img src='" . $valor["foto"] . "'>
            <h3>" . $valor["nombre"] . "</h3>
            <p>" . $valor["precio"] . " $</p>
        </div>
        ";
    }
?>

    
</body>

</html>
