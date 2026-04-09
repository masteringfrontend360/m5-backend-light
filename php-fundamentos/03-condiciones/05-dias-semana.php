<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Día de la semana</title>

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

<h1>Día de la semana</h1>

<form method="post">
    <label>
        Número del 1 al 7:
        <input type="number" name="dia" min="1" max="7">
    </label>
    <button type="submit">Mostrar día</button>
</form>

<?php

$dia_switch = null;
$dia_match = null;

if (isset($_POST['dia'])) {

    // Convertimos a entero para evitar problemas de comparación estricta
    $dia = (int) $_POST['dia'];

    // ---------- versión clásica con switch ----------

    switch ($dia) {
        case 1:
            $dia_switch = "Lunes";
            break;
        case 2:
            $dia_switch = "Martes";
            break;
        case 3:
            $dia_switch = "Miércoles";
            break;
        case 4:
            $dia_switch = "Jueves";
            break;
        case 5:
            $dia_switch = "Viernes";
            break;
        case 6:
            $dia_switch = "Sábado";
            break;
        case 7:
            $dia_switch = "Domingo";
            break;
        default:
            $dia_switch = "Número inválido";
    }

    // ---------- versión moderna con match ----------

    $dia_match = match($dia) {
        1 => "Lunes",
        2 => "Martes",
        3 => "Miércoles",
        4 => "Jueves",
        5 => "Viernes",
        6 => "Sábado",
        7 => "Domingo",
        default => "Número inválido"
    };
}

?>

<?php if ($dia_switch !== null): ?>

<div class="result">

Resultado con switch → <?php echo $dia_switch; ?>

<br><br>

Resultado con match → <?php echo $dia_match; ?>

</div>

<?php endif; ?>

<p>

<b>Explicación:</b><br><br>

switch compara el valor con distintos casos y necesita <b>break</b>.<br><br>

match es una forma moderna de PHP que:<br>

- usa comparación estricta<br>
- no necesita break<br>
- devuelve directamente el resultado.<br><br>

Convertimos el valor del formulario a entero con <b>(int)</b> porque los datos enviados por formularios llegan como texto.

</p>

</div>

</body>
</html>