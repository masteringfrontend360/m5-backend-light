<?php
// foreach.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ejercicio foreach</title>

<style>

body{
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 30px auto;
    background:#f4f4f4;
}

.box{
    background:white;
    padding:20px;
    margin-top:20px;
    border-radius:8px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

form{
    display:grid;
    gap:12px;
}

label{
    font-weight:bold;
}

input, textarea, select, button{
    padding:8px;
    font-size:16px;
}

textarea{
    min-height:120px;
}

.result{
    background:#eef;
    padding:10px;
    margin-top:10px;
}

</style>

</head>
<body>

<h1>Formulario de datos personales</h1>

<form method="post">

<div>
<label for="nombre">Nombre</label><br>
<input type="text" name="nombre" id="nombre">
</div>

<div>
<label for="apellidos">Apellidos</label><br>
<input type="text" name="apellidos" id="apellidos">
</div>

<div>
<label for="email">Email</label><br>
<input type="email" name="email" id="email">
</div>

<div>
<label for="fecha_nacimiento">Fecha de nacimiento</label><br>
<input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
</div>

<div>
<label for="direccion">Dirección</label><br>
<input type="text" name="direccion" id="direccion">
</div>

<div>
<label for="codigo_postal">Código postal</label><br>
<input type="text" name="codigo_postal" id="codigo_postal">
</div>

<div>
<label for="provincia">Provincia</label><br>
<select name="provincia" id="provincia">
<option value="">Selecciona una provincia</option>
<option value="Zaragoza">Zaragoza</option>
<option value="Huesca">Huesca</option>
<option value="Teruel">Teruel</option>
<option value="Otra">Otra</option>
</select>
</div>

<div>
<label for="comentarios">Comentarios</label><br>
<textarea name="comentarios" id="comentarios"></textarea>
</div>

<div>
<button type="submit">Enviar</button>
</div>

</form>



<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

echo '<div class="box">';
echo '<h2>Datos enviados</h2>';

echo '<div class="result">';
echo '<ul>';

foreach ($_POST as $campo => $valor) {

    if ($valor !== "") {
        echo "<li><b>$campo</b>: $valor</li>";
    }

}

echo '</ul>';
echo '</div>';

echo '</div>';

}

?>

</body>
</html>