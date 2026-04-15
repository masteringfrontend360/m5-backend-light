<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Par o impar</title>
</head>
<body>
    <h1>Número par o impar</h1>

    <form method="post">
        <label>
            Escribe un número entero:
            <input type="number" name="numero">
        </label>
        <button type="submit">Comprobar</button>
    </form>

    <?php
    // 1. Comprobar que se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 2. Recuperar el número entero
        $numero = $_POST['numero'] ?? null;
        
        // 3. Usar el operador % para decidir si es par o impar
        if ($numero % 2 === 0) {
            // Si el resto de dividir por 2 es 0, es par
            echo "<p>El número $numero es par.</p>";
        } else {
            // Si no, es impar
            echo "<p>El número $numero es impar.</p>";
        }
        
        // 4. El mensaje solo se muestra después de enviar (ya está controlado con el if)
    }
    ?>
</body>
</html>