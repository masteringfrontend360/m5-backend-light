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

    <?php // 1. Comprobar envío del formulario 
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $edad = $_GET["edad"];
        // 2. Recuperar la edad. Valida que la edad no sea negativa antes de clasificar. 
        if ($edad >= 0) {
            // 3. Usar una cadena de if / elseif / else para decidir: 
            // - Niño: 0 a 12 
            // - Adolescente: 13 a 17 
            // - Adulto: 18 a 64 
            // - Jubilado: 65 o más 
            if ($edad < 13) {
                $categoria = "Niño";
            } else if ($edad >= 13 && $edad < 18) {
                $categoria = "Adolescente";
            } else if ($edad >= 18 && $edad < 65) {
                $categoria = "Adulto";
            } else {
                $categoria = "Jubilado";
            }
        } else {
            echo "error";
        }
    }
    echo $categoria; // Ordena bien las condiciones para que ninguna se pise (piensa en rangos). // 4. Mostrar el mensaje de categoría 
    ?>
</body>

</html>