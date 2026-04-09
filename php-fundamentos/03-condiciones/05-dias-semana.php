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
   /*
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dia'])) {
    $dia = intval($_POST['dia']);

    if ($dia == 1) {
        echo "<p>Lunes</p>";
    } elseif ($dia == 2) {
        echo "<p>Martes</p>";
    } elseif ($dia == 3) {
        echo "<p>Miércoles</p>";
    } elseif ($dia == 4) {
        echo "<p>Jueves</p>";
    } elseif ($dia == 5) {
        echo "<p>Viernes</p>";
    } elseif ($dia == 6) {
        echo "<p>Sábado</p>";
    } elseif ($dia == 7) {
        echo "<p>Domingo</p>";
    } else {
        echo "<p>Introduce un número válido entre 1 y 7</p>";
    }
        }

*/
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dia'])) {
    $dia = intval($_POST['dia']);

    $nombreDia = match($dia) {
        1 => "Lunes",
        2 => "Martes",
        3 => "Miércoles",
        4 => "Jueves",
        5 => "Viernes",
        6 => "Sábado",
        7 => "Domingo",
        default => "Introduce un número válido entre 1 y 7",
    };

    echo "<p>$nombreDia</p>";
}




    
    // 1. Comprobar envío del formulario
    // 2. Recuperar el número de día
    // 3. Versión básica: usar if / elseif o switch
    //    - 1: lunes
    //    - 2: martesgi
    //    - ...
    //    - 7: domingo
    // 4. Mostrar el nombre del día o un mensaje de error si el número es inválido

    // Repetir usando match para devolver el nombre del día.
    ?>
</body>
</html>