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
    if( $_SERVER["REQUEST_METHOD"] == "POST"){
    $numero = $_POST['numero'] ?? 0;
        if($numero == 0){
            echo "El numero es cero";
        } elseif($numero > 0){
            echo "El numero es positivo";
        } else {
            echo "El numero es negativo";
        }
    }
    // 2. Recuperar el número enviado
    // 3. Usar if / elseif / else para mostrar:
    //    - "El número es positivo"
    //    - "El número es negativo"
    //    - "El número es cero"
    ?>
</body>
</html>