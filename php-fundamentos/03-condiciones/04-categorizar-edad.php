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
    // 1. Comprobar envío del formulario
    // 2. Recuperar la edad. Valida que la edad no sea negativa antes de clasificar.
    // 3. Usar una cadena de if / elseif / else para decidir:
    //    - Niño: 0 a 12
    //    - Adolescente: 13 a 17
    //    - Adulto: 18 a 64
    //    - Jubilado: 65 o más
    // Ordena bien las condiciones para que ninguna se pise (piensa en rangos).
    // 4. Mostrar el mensaje de categoría
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $edad = intval($_POST['edad'] ?? -1);
        if ($edad < 0) {
            echo "La edad no puede ser negativa";
        } else if ($edad <= 12) {
            echo "Eres un niño";
        } else if ($edad <= 17) {
            echo "Eres un adolescente";
        } else if ($edad <= 64) {
            echo "Eres un adulto";
        } else {
            echo "Eres un jubilado";
        }
    }
    ?>
</body>

</html>