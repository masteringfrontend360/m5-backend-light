<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Par o impar</title>
</head>
<body>
    <h1>Número par o impar</h1>

    <form method="post">
        <label>
            Escribe un número entero:
            <input type="number" name="numero">
        </label>
        <button type="submit">Comprobar</button>
    </form>

    <?php
    // 1. Comprobar que se ha enviado el formulario
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $numero = $_POST['numero'] ?? 0;

        if($numero % 2 == 0){

        }
    }

    // 2. Recuperar el número entero
    // 3. Usar el operador % (módulo) para decidir si es par o impar. Recuerda que un número es par si el resto de dividirlo entre 2 es 0.
    // 4. Mostrar un mensaje con el resultado. Controla que el mensaje solo se vea después de enviar el formulario.
    ?>
</body>
</html>