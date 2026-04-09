<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clasificación por edad</title>
</head>
<body>
    <h1>Clasificación por edad</h1>

    <form method="post">
        <label>
            Introduce tu edad:
            <input type="number" name="edad" min="0">
        </label>
        <button type="submit">Clasificar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edad'])) {
    $edad = intval($_POST['edad']);

    if ($edad < 0) {
        echo "<p>Introduce una edad válida (no negativa)</p>";
    } else {
        
        if ($edad <= 12) {
            echo "<p>Eres un Niño</p>";
        } elseif ($edad <= 17) {
            echo "<p>Eres un Adolescente</p>";
        } elseif ($edad <= 64) {
            echo "<p>Eres un Adulto</p>";
        } else {
            echo "<p>Eres un Jubilado</p>";
        }
    }
}
    
    // 1. Comprobar envío del formulario
    // 2. Recuperar la edad. Valida que la edad no sea negativa antes de clasificar.
    // 3. Usar una cadena de if / elseif / else para decidir:
    //    - Niño: 0 a 12
    //    - Adolescente: 13 a 17
    //    - Adulto: 18 a 64
    //    - Jubilado: 65 o más
    // Ordena bien las condiciones para que ninguna se pise (piensa en rangos).
    // 4. Mostrar el mensaje de categoría
    ?>
</body>
</html>