<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Par o impar</title>

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

<h1>Número par o impar</h1>

<form method="post">
    <label>
        Escribe un número entero:
        <input type="number" name="numero">
    </label>
    <button type="submit">Comprobar</button>
</form>

<?php

$resultado = null;

// 1. Comprobar si se envió el formulario
if (isset($_POST['numero'])) {

    // 2. Recuperar el número
    $numero = $_POST['numero'];

    // 3. Comprobar si es par o impar usando el operador %
    if ($numero % 2 === 0) {
        $resultado = "El número es par";
    } else {
        $resultado = "El número es impar";
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

El operador <b>%</b> devuelve el resto de una división.<br><br>

Si dividimos un número entre 2:

Si el resto es <b>0</b> → el número es <b>par</b>.<br>
Si el resto es <b>1</b> → el número es <b>impar</b>.<br><br>

Ejemplos:<br>

8 % 2 = 0 → par<br>
7 % 2 = 1 → impar

</p>

</div>

</body>
</html>