<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clasificación por edad</title>
</head>
<body>
    <h1>Clasificación por edad</h1>

    <form method="get">
        <label>
            Introduce tu edad:
            <input type="number" name="edad" min="0" max="110">
        </label>
        <button type="submit">Clasificar</button>
    </form>

    <?php
    // 1. Comprobar envío del formulario
    if (isset($_GET['edad'])) {
        // 2. Recuperar la edad y validar que no sea negativa
        $edad = $_GET['edad'];
        
        if ($edad < 0) {
            echo "<p>Error: La edad no puede ser negativa.</p>";
        } else {
            // 3. Usar if / elseif / else para clasificar
            if ($edad <= 12) {
                $categoria = "Niño";
            } elseif ($edad <= 17) {
                $categoria = "Adolescente";
            } elseif ($edad <= 64) {
                $categoria = "Adulto";
            } else {
                $categoria = "Jubilado";
            }
            
            // 4. Mostrar el mensaje de categoría
            echo "<p>Con $edad años, eres un $categoria.</p>";
        }
    }
    ?>
</body>
</html>