<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Día de la semana</title>
</head>

<body>
    <h1>Día de la semana</h1>

    <form method="post">
        <label>
            Número del 1 al 7:
            <input type="number" name="dia" min="1" max="7">
        </label>
        <button type="submit">Mostrar día</button>
    </form>

    <?php
    // 1. Comprobar envío del formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // 2. Recuperar el número de día
        $dia = $_POST["dia"];
        switch ($dia) {
            case "1":
                echo "Lunes";
                break;
            case "2":
                echo "Martes";
                break;
            case "3":
                echo "Miercoles";
                break;
            case "4":
                echo "Jueves";
                break;
            case "5":
                echo "Viernes";
                break;
            case "6":
                echo "Sabado";
                break;
            case "7":
                echo "Domingo";
                break;
            default:
                echo "Error";
        }
    }
    
    // 3. Versión básica: usar if / elseif o switch
    //    - 1: lunes
    //    - 2: martes
    //    - ...
    //    - 7: domingo


    // 4. Mostrar el nombre del día o un mensaje de error si el número es inválido

    // Repetir usando match para devolver el nombre del día.
    ?>
</body>

</html>