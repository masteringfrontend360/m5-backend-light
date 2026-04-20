<?php
header('Content-Type: application/json; charset=UTF-8');


// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}


/*
|--------------------------------------------------------------------------
| 1. Normalizar datos de entrada
|--------------------------------------------------------------------------
*/
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

$errores = [];
$datosLimpios = [];

/*
|--------------------------------------------------------------------------
| 2. Validación del nombre
|--------------------------------------------------------------------------
| - obligatorio
| - longitud mínima y máxima
| - solo letras, espacios, apóstrofes y guiones
*/
if ($nombre === '') {
    $errores['nombre'] = 'El nombre es obligatorio.';
} elseif (mb_strlen($nombre) < 2) {
    $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
} elseif (mb_strlen($nombre) > 50) {
    $errores['nombre'] = 'El nombre no puede superar 50 caracteres.';
} elseif (!preg_match('/^[\p{L}\s\'-]+$/u', $nombre)) {
    $errores['nombre'] = 'El nombre solo puede contener letras, espacios, apóstrofes y guiones.';
} else {
    $datosLimpios['nombre'] = $nombre;
}

/*
|--------------------------------------------------------------------------
| 3. Validación del email
|--------------------------------------------------------------------------
| - obligatorio
| - longitud mínima y máxima
| - formato válido
*/
if ($email === '') {
    $errores['email'] = 'El email es obligatorio.';
} elseif (mb_strlen($email) < 5) {
    $errores['email'] = 'El email debe tener al menos 5 caracteres.';
} elseif (mb_strlen($email) > 100) {
    $errores['email'] = 'El email no puede superar 100 caracteres.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = 'El email no tiene un formato válido.';
} else {
    $datosLimpios['email'] = $email;
}

/*
|--------------------------------------------------------------------------
| 3. Validación de ciudad
|--------------------------------------------------------------------------
| - longitud mínima y máxima
| - formato válido
*/
if (mb_strlen($ciudad) < 5) {
    $errores['ciudad'] = 'La ciudad debe tener al menos 5 caracteres.';
} elseif (mb_strlen($ciudad) > 100) {
    $errores['ciudad'] = 'La ciudad no puede superar 100 caracteres.';
} else {
    $datosLimpios['ciudad'] = $ciudad;
}

/*
|--------------------------------------------------------------------------
| 4. Si hay errores, devolver JSON con código 422
|--------------------------------------------------------------------------
*/
if (!empty($errores)) {
    http_response_code(422);

    echo json_encode([
        'ok' => false,
        'errores' => $errores
    ]);
    exit;
} else {
    require 'conexion.php';

    // Insertar datos con sentencia preparada
try {
    $sql = "INSERT INTO contactos (nombre, email, ciudad)
            VALUES (:nombre, :email, :ciudad)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nombre' => $nombre,
        ':email'  => $email,
        ':ciudad' => $ciudad
    ]);

    header('Location: listado.php?success=1');
    exit;
} catch (PDOException $e) {
    if ($e->errorInfo[1] === 1062) {
        $errores['email'] = 'Ya existe un contacto con ese email.';
        http_response_code(422);

        echo json_encode([
            'ok' => false,
            'errores' => $errores
        ]);
        exit;
    } else {
        // echo $e->getMessage();
        // echo '❌ Error al guardar el contacto';
    }
}
/*
|--------------------------------------------------------------------------
| 5. Si todo está bien, devolver respuesta de éxito
|--------------------------------------------------------------------------
|
| A partir de aquí, en un siguiente paso del curso, el proceso será:
|
| 1. Crear o reutilizar la conexión a la base de datos con PDO.
|
| 2. Configurar la conexión con:
|    - charset utf8mb4
|    - modo de errores con excepciones
|
| 3. Escribir una consulta SQL con placeholders, por ejemplo:
|    INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)
|
| 4. Preparar la consulta con prepare().
|
| 5. Ejecutar la consulta pasando los valores de $datosLimpios.
|
| 6. Comprobar si la inserción se ha realizado correctamente.
|
| 7. Devolver un JSON de éxito al frontend.
|
| 8. Si ocurre un error en la base de datos, capturarlo con try/catch
|    y devolver un JSON controlado, sin enseñar detalles técnicos
|    sensibles al usuario final.
*/
// echo json_encode([
//     'ok' => true,
//     'mensaje' => 'Formulario validado correctamente. Listo para guardar en base de datos.'
// ]);
}