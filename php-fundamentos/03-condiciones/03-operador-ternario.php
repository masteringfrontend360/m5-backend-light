<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de una nota</title>
</head>
<body>
    <h1>Resultado de una nota</h1>

    <form method="post">
        <label>
            Introduce una nota (0-10):
            <input type="number" name="nota" step="0.1">
        </label>
        <button type="submit">Evaluar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nota'])) {
    $nota = floatval($_POST['nota']);
    
    if ($nota < 0 || $nota > 10) {
        echo "<p>Introduce una nota válida entre 0 y 10</p>";
        
        } else {
        $mensaje = ($nota >= 5) ? "Aprobado" : "Suspendido";
        echo "<p>$mensaje</p>";
    }
    
        }
        
        /*else {
             if ($nota >= 5) {
                echo "<p>Aprobado</p>";
            } else {
                echo "<p>Suspendido</p>";
            }
         }
    */
    // 1. Comprobar que se ha enviado el formulario
    // 2. Recuperar la nota
    // 3. Comprobar que está entre 0 y 10 (validación básica). Añade una comprobación por si el usuario introduce una nota fuera de rango.
    // 4. Usar if / else para mostrar "Aprobado" o "Suspendido"

    // OPCIONAL:
    // - Repite la lógica usando el operador ternario en una variable,
    //   y luego muestra el mensaje con echo.
    // piensa en: condición ? valor_si_verdadero : valor_si_falso
    ?>
</body>
</html>