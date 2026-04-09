<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Resultado de una nota</title>

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

<h1>Resultado de una nota</h1>

<form method="post">
    <label>
        Introduce una nota (0-10):
        <input type="number" name="nota" min="0" max="10" step="0.1">
    </label>
    <button type="submit">Evaluar</button>
</form>

<?php

$resultado_if = null;
$resultado_ternario = null;

if (isset($_POST['nota'])) {

    $nota = $_POST['nota'];

    // Validación básica
    if ($nota < 0 || $nota > 10) {
        $resultado_if = "La nota debe estar entre 0 y 10";
    } else {

        // Forma clásica con if / else
        if ($nota >= 5) {
            $resultado_if = "Aprobado";
        } else {
            $resultado_if = "Suspendido";
        }

        // Forma con operador ternario
        $resultado_ternario = ($nota >= 5) ? "Aprobado" : "Suspendido";
    }
}

?>

<?php if ($resultado_if !== null): ?>

<div class="result">

Resultado con if/else → <?php echo $resultado_if; ?>

<?php if ($resultado_ternario !== null): ?>
<br><br>
Resultado con operador ternario → <?php echo $resultado_ternario; ?>
<?php endif; ?>

</div>

<?php endif; ?>

<p>

<b>Explicación:</b><br><br>

Si la nota es mayor o igual que <b>5</b> → aprobado.<br>
Si es menor que <b>5</b> → suspendido.<br><br>

El operador ternario permite escribir la misma lógica en una sola línea:

<br><br>

<b>condición ? valor_si_verdadero : valor_si_falso</b>

</p>

</div>

</body>
</html>