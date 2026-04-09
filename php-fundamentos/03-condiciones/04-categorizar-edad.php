<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Clasificación por edad</title>

<style>

body{
    font-family: Arial;
    margin:40px;
    background:#f4f4f4;
}

.box{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:8px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.result{
    background:#eef;
    padding:10px;
    margin-top:10px;
}

</style>

</head>

<body>

<div class="box">

<h1>Clasificación por edad</h1>

<form method="post">
    <label>
        Introduce tu edad:
        <input type="number" name="edad" min="0">
    </label>
    <button type="submit">Clasificar</button>
</form>

<?php

$resultado = null;

if (isset($_POST['edad'])) {

    $edad = $_POST['edad'];

    // Validación básica
    if ($edad < 0) {
        $resultado = "La edad no puede ser negativa";
    } else {

        // Clasificación por rangos
        if ($edad <= 12) {
            $resultado = "Niño";
        } elseif ($edad <= 17) {
            $resultado = "Adolescente";
        } elseif ($edad <= 64) {
            $resultado = "Adulto";
        } else {
            $resultado = "Jubilado";
        }
    }
}

?>

<?php if ($resultado !== null): ?>

<div class="result">
Categoría → <?php echo $resultado; ?>
</div>

<?php endif; ?>

<p>

<b>Explicación:</b><br><br>

Usamos una cadena de condiciones <b>if / elseif / else</b> para clasificar la edad.<br><br>

0-12 → Niño<br>
13-17 → Adolescente<br>
18-64 → Adulto<br>
65+ → Jubilado<br><br>

Las condiciones se evalúan en orden, por eso es importante definir bien los rangos.

</p>

</div>

</body>
</html>