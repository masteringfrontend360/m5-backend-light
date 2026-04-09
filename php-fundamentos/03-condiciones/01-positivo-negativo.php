<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Signo de un número</title>

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

<h1>Signo de un número</h1>

<form method="post">
    <label>
        Escribe un número:
        <input type="number" name="numero" step="any">
    </label>
    <button type="submit">Comprobar</button>
</form>

<?php

$resultado = null;

// 1. Comprobar si se envió el formulario
if (isset($_POST['numero'])) {

    // 2. Recuperar el número
    $numero = $_POST['numero'];

    // 3. Evaluar el signo
    if ($numero > 0) {
        $resultado = "El número es positivo";
    } elseif ($numero < 0) {
        $resultado = "El número es negativo";
    } else {
        $resultado = "El número es cero";
    }
}

?>

<?php if ($resultado !== null): ?>

<div class="result">
<?php echo $resultado; ?>
</div>

<?php endif; ?>

<p>
<b>Explicación:</b><br><br>

Si el número es mayor que 0 → positivo.<br>
Si es menor que 0 → negativo.<br>
Si no cumple ninguna de las dos → es 0.
</p>

</div>

</body>
</html>