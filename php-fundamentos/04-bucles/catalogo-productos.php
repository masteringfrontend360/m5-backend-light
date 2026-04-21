<?php
/*
Objetivo: Array multidimensional + ordenación + mostrar en HTML.

Enunciado:

Crea un array $productos con 4 productos (cada uno con nombre, precio, stock, foto como URL placeholder tipo https://placehold.co/200x300?text=Camiseta).

Muéstralos en tarjetas HTML.

Añade un <select> para ordenar por precio (asc/desc). Al enviar, reordena con asort() o arsort() y muestra el catálogo ordenado.

💡 Pistas:

Estructura: $productos = [ ['nombre'=>'Camiseta', 'precio'=>19.95, 'stock'=>10, 'foto'=>'url'], ... ];
Tarjeta HTML: <div class="producto"><img src="..."> <h3>...</h3> <p>€...</p></div>.
Ordena con if ($_POST['orden'] === 'asc') usort($productos)
Este array es lo que devuelve wc_get_products(). Transición: $productos = [ ... ]; → $productos = wc_get_products(['limit'=>4]);
¡Prueba! Usa print_r($productos); para depurar antes de mostrar.
*/
$productos = [
    [
        'nombre' => 'Camiseta',
        'precio' => 30.80,
        'stock' => 10,
        'foto' => 'https://placehold.co/200x300?text=Camiseta'
    ],
    [
        'nombre' => 'Pantalón',
        'precio' => 20.80,
        'stock' => 7,
        'foto' => 'https://placehold.co/200x300?text=Pantalón'
    ],
     [
        'nombre' => 'Jersey',
        'precio' => 32.50,
        'stock' => 20,
        'foto' => 'https://placehold.co/200x300?text=Jersey'
    ],
    [
        'nombre' => 'Sudadera',
        'precio' => 15.30,
        'stock' => 6,
        'foto' => 'https://placehold.co/200x300?text=Sudadera'
    ]

];
echo '<pre>';
print_r($productos);
echo '</pre>';
echo '<pre>';
var_dump($productos);
echo '</pre>';
$asc = '';
$error = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $orderByPrice = $_POST['orderByPrice'] ?? '';
    $selected = '';
    if($orderByPrice === 'ASC'){
        $asc = true;
        usort($productos, function ($a, $b) {
            return $a['precio'] <=> $b['precio'];
        });
        //echo 'Más barato primero';
    }elseif ($orderByPrice === 'DESC'){
        $asc = false;
        usort($productos, function ($a, $b) {
            return $b['precio'] <=> $a['precio'];
        });
        //echo 'Más caro primero';
    }elseif (empty($orderByPrice)){
        $error[] = 'Tienes que seleccionar un orden';
    }else{
        $error[] = 'No es un valor esperado';
    }
}

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
    foreach ($error as $v){
        echo $v . '<br>';
    }
    ?>
    <form action="" method="post">
    <select name="orderByPrice" id="orderByPrice">
        <option value="">Ordenar por precio</option>
        <option value="ASC" <?php echo $asc === true ? 'selected' : '' ; ?>>Más bajo primero</option>
        <option value="DESC" <?php echo $asc === false ? 'selected' : '' ; ?>>Más caro primero</option>
    </select>
    <button>Ordenar</button>
    </form>
    <?php
    foreach ($productos as $producto): // $producto es un array
        ?>
        <div class="producto"><img src="<?= $producto['foto']; ?>"> <h3><?= $producto['nombre']; ?></h3> <p><?= number_format($producto['precio'], 2, ',', '.'); ?> €</p></div>
<?php
    endforeach;
    ?>
     
</body>
</html>
