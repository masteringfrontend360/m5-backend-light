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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 2. Recuperar el número de día
        $dia = $_POST['dia'] ?? null;
        
        // 3. Versión básica: usar if / elseif para asignar días
        if ($dia == 1) {
            $nombreDia = "lunes";
        } elseif ($dia == 2) {
            $nombreDia = "martes";
        } elseif ($dia == 3) {
            $nombreDia = "miércoles";
        } elseif ($dia == 4) {
            $nombreDia = "jueves";
        } elseif ($dia == 5) {
            $nombreDia = "viernes";
        } elseif ($dia == 6) {
            $nombreDia = "sábado";
        } elseif ($dia == 7) {
            $nombreDia = "domingo";
        } else {
            $nombreDia = null; // Número inválido
        }
        
        // 4. Mostrar el nombre del día o error
        if ($nombreDia) {
            echo "<p>El día $dia es $nombreDia.</p>";
        } else {
            echo "<p>Error: Introduce un número del 1 al 7.</p>";
        }
        
        // Repetir usando match (PHP 8+)
        $diaMatch = match ($dia) {
            1 => "lunes",
            2 => "martes",
            3 => "miércoles",
            4 => "jueves",
            5 => "viernes",
            6 => "sábado",
            7 => "domingo",
            default => null,
        };
        
        if ($diaMatch) {
            echo "<p>(Usando match: El día $dia es $diaMatch)</p>";
        }
    }
    ?>
</body>
</html>