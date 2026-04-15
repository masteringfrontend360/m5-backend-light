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
            <input type="number" name="nota" min="0" max="10" step="0.1">
        </label>
        <button type="submit">Evaluar</button>
    </form>

    <?php
    // 1. Comprobar que se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 2. Recuperar la nota
        $nota = $_POST['nota'] ?? null;
        
        // 3. Validación básica: comprobar que está entre 0 y 10
        if ($nota < 0 || $nota > 10) {
            echo "<p>Error: La nota debe estar entre 0 y 10.</p>";
        } else {
            // 4. Usar if / else para mostrar "Aprobado" o "Suspendido"
            if ($nota >= 5) {
                echo "<p>Aprobado con nota $nota.</p>";
            } else {
                echo "<p>Suspendido con nota $nota.</p>";
            }
            
            // OPCIONAL: Repite la lógica usando el operador ternario
            $resultado = ($nota >= 5) ? "Aprobado" : "Suspendido";
            echo "<p>(Usando ternario: $resultado con nota $nota)</p>";
        }
    }
    ?>
</body>
</html>