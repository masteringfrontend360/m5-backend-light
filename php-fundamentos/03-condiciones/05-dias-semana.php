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
    // 2. Recuperar el número de día
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