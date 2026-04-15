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
    // 1. Comprobar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 2. Recuperar el número enviado
        $numero = $_POST['numero'] ?? null;
        
        // 3. Usar if / elseif / else para mostrar el resultado
        if ($numero > 0) {
            echo "<p>El número $numero es positivo.</p>";
        } elseif ($numero < 0) {
            echo "<p>El número $numero es negativo.</p>";
        } else {
            echo "<p>El número $numero es cero.</p>";
        }
    }
    ?>
</body>
</html>