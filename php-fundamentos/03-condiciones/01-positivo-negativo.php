<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Signo de un número</title>
</head>
<body>
    <h1>Signo de un número</h1>

    <form method="post">
        <label>
            Escribe un número:
            <input type="number" name="numero" step="any">
        </label>
        <button type="submit">Comprobar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numero'])) {
    $numero = floatval($_POST['numero']);
    echo $numero;
    }
        if ($numero > 0) {
        echo "<p>El número es positivo</p>";
    } elseif ($numero < 0) {
        echo "<p>El número es negativo</p>";
    } else {
        echo "<p>El número es cero</p>";
    }

    // 2. Recuperar el número enviado
    // 3. Usar if / elseif / else para mostrar:
    //    - "El número es positivo"
    //    - "El número es negativo"
    //    - "El número es cero"
    ?>
</body>
</html>