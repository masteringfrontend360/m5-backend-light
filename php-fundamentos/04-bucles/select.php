
<!-- Objetivo: Crear y mostrar un array indexado en un select. Recoger $_POST y mostrar resultado. -->

 <!-- Enunciado:
 Crea un formulario con un select que muestre localidades de Aragón (mínimo 5: Zaragoza, Huesca, Teruel, Calatayud, Tarazona).
 El array de localidades debe definirse en PHP. Al enviar, muestra: "Has seleccionado: Zaragoza".

 Pistas:
 Define $localidades = ['Zaragoza', 'Huesca', 'Teruel', ...];
 Usa foreach para generar option.
 Usa $_POST['localidad'] ?? 'Ninguna';
 Prueba en localhost. -->
<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body>

<form action="" method="post">

<?php
$localidades = ['Zaragoza', 'Huesca', 'Teruel', 'Calatayud', 'Tarazona'];

echo "<select name='localidad'>";

foreach ($localidades as $localidad) {
   echo "<option value='" . $localidad . "'>" . $localidad . "</option>";
}

echo "</select>";
?>

<button type="submit">Enviar</button>

</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $respuesta = $_POST["localidad"];
    echo "Has seleccionado: " . $respuesta;
}
?>

</body>
</html>