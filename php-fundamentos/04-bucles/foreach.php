<?php
// foreach.php

/*
Ejercicio:
Crear un formulario con campos como nombre, apellidos, email,
fecha de nacimiento, dirección, código postal, provincia y comentarios.
Al enviar el formulario, recorrer los datos recibidos con foreach
y mostrar una lista con el nombre de cada campo y su valor.

Guía:
- El formulario HTML ya está creado.
- El trabajo del alumno empieza al recibir los datos.
- Comprueba si el formulario se ha enviado.
- Recorre $_POST con foreach.
- Muestra cada campo y su valor en una lista.
- Como mejora opcional, puedes ignorar campos vacíos.
*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio foreach</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
        }

        form {
            display: grid;
            gap: 12px;
        }

        label {
            font-weight: bold;
        }

        input, textarea, select, button {
            padding: 8px;
            font-size: 16px;
        }

        textarea {
            min-height: 120px;
        }
    </style>
</head>
<body>

    <h1>Formulario de datos personales</h1>

    <form action="" method="post">
        <div>
            <label for="nombre">Nombre</label><br>
            <input type="text" name="nombre" id="nombre">
        </div>

        <div>
            <label for="apellidos">Apellidos</label><br>
            <input type="text" name="apellidos" id="apellidos">
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email">
        </div>

        <div>
            <label for="fecha_nacimiento">Fecha de nacimiento</label><br>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
        </div>

        <div>
            <label for="direccion">Dirección</label><br>
            <input type="text" name="direccion" id="direccion">
        </div>

        <div>
            <label for="codigo_postal">Código postal</label><br>
            <input type="text" name="codigo_postal" id="codigo_postal">
        </div>

        <div>
            <label for="provincia">Provincia</label><br>
            <select name="provincia" id="provincia">
                <option value="">Selecciona una provincia</option>
                <option value="Zaragoza">Zaragoza</option>
                <option value="Huesca">Huesca</option>
                <option value="Teruel">Teruel</option>
                <option value="Otra">Otra</option>
            </select>
        </div>

        <div>
            <label for="comentarios">Comentarios</label><br>
            <textarea name="comentarios" id="comentarios"></textarea>
        </div>

        <div>
            <button type="submit">Enviar</button>
        </div>
    </form>

    <hr>

    <?php
    // TODO:
    // 1. Comprobar si el formulario se ha enviado.
    // 2. Recorrer el array $_POST con foreach.
    // 3. Mostrar una lista HTML con el nombre de cada campo y su valor.

    /*
    Pistas:
    - Puedes comprobar si se ha enviado usando $_SERVER["REQUEST_METHOD"].
    - foreach necesita dos variables: una para la clave y otra para el valor.
    - Puedes usar <ul> y <li> para mostrar los resultados.
    */
    ?>

</body>
</html>