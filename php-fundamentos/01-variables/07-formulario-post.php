<?php

$nombre = $_POST['nombre'] ?? '';
$edad = $_POST['edad'] ?? '';
$suscrito = $_POST['suscrito'] ?? '';

?>

<form method="POST" action="">
    <p>
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre">
    </p>

    <p>
        <label for="edad">Edad</label><br>
        <input type="number" name="edad" id="edad">
    </p>

    <p>
        <label>
            <input type="checkbox" name="suscrito" value="si">
            Suscrito
        </label>
    </p>

    <button type="submit">Enviar</button>
</form>

<?php

// TODO:
// - Mostrar mensaje si el usuario es mayor o menor de edad
// - Mostrar mensaje si está suscrito o no
// - Usar var_dump($_POST)

?>