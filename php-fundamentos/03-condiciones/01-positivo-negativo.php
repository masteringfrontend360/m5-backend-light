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
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        echo "Enviado correctamente";
    } else {
        echo "No se ha enviado";
    }

    // 2. Recuperar el número enviado
    $numero = $_POST["numero"];


    // 3. Usar if / elseif / else para mostrar:
    //    - "El número es positivo"
    //    - "El número es negativo"
    //    - "El número es cero"
        if ($numero > 0) {
        echo "El numero es positivo";
        } else if ($numero < 0) {
        echo "El numero es negativo";
        } else {
            echo "El numero es cero";
        }

    ?>
</body>

</html>