<?php
// Objetivo: Crear y mostrar un array indexado en un <select>. Recoger $_POST y mostrar resultado.

// Enunciado:

// Crea un formulario con un <select> que muestre localidades de Aragón (usa al menos 5: Zaragoza, Huesca, Teruel, Calatayud, Tarazona). El array de localidades debe definirse en PHP. Al enviar, muestra un mensaje como "Has seleccionado: Zaragoza".

// 💡 Pistas paso a paso:

// Define $localidades= ['Zaragoza', 'Huesca', 'Teruel', ...]; al inicio del archivo PHP.
// Usa foreach para generar las <option value="...">.
// Valida con $_POST['localidad'] ?? 'Ninguna';.
// ¡Prueba! Accede por http://localhost/tu-archivo.php en WSL.


$localidades = [
    1 => 'Zaragoza',
    2 => 'Huesca',
    3 => 'Teruel',
];

$mensaje = '';
//$localidad = $_POST['localidad'] ?? ''; // si existe, si es null, si es falsy

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $localidadRaw = $_POST['localidad'] ?? '';

    if ($localidadRaw === '') {
        $mensaje = 'Selecciona una localidad válida.';
    } else {
    $localidad = filter_input(INPUT_POST, 'localidad', FILTER_VALIDATE_INT);
    }
    if ($localidad !== false && array_key_exists($localidad, $localidades)) {
        $mensaje = 'Has seleccionado ' . htmlspecialchars($localidades[$localidad], ENT_QUOTES, 'UTF-8');
    } else {
        $mensaje = 'Selecciona una localidad válida.';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select localidades</title>
</head>
<body>
    <form action="" method="post">
        <label for="localidad">Localidad</label>
        <select name="localidad" id="localidad" required>
            <option value="">Selecciona localidad</option>
            <?php
            foreach ($localidades as $k => $v){
                echo '<option value="'.$k.'">'.$v.'</option>';
            }
            ?>
            
        </select>
        <button>Enviar</button>
    </form>

<?=$mensaje; ?>

</body>
</html>
