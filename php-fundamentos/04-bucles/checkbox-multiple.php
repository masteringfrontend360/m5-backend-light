<?php
    $habilidades = ['HTML', 'CSS', 'JS', 'SEO'];
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
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    $habilidadesPost = $_POST['habilidades'] ?? [];
    $habilidadesPost = array_intersect($habilidadesPost, $habilidades); // Elimina cualquier habilidad enviada que no existiese en el array original
    if (count($habilidadesPost) > 0){
        echo 'Tienes las siguientes habilidades: ';
        // foreach ($habilidadesPost as $v){
        //     echo $v . ',';
        // }
        echo implode (', ', $habilidadesPost) . '.';
    }else{
        echo 'No tienes';
    }
else:
?>
    <form action="" method="post">
    <fieldset>
        <legend>Habilidades frontend</legend>
        <?php
        foreach($habilidades as $k => $v){
        echo <<<CHECKBOX
        <input type="checkbox" name="habilidades[]" id="habilidades_$k" value="$v">
        <label for="habilidades_$k">$v</label>
CHECKBOX;
        }
        ?>
    </fieldset>
    <button>Enviar</button>
    </form>
</body>
</html>
<?php
endif;
?>