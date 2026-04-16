<?php
session_start();

/*
|--------------------------------------------------------------------------
| 1. Normalizar datos de entrada
|--------------------------------------------------------------------------
*/
$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email'] ?? '');

$errores = [];
$datosLimpios = [];

/*
|--------------------------------------------------------------------------
| 2. Validación del nombre (texto plano)
|--------------------------------------------------------------------------
| - obligatorio
| - longitud mínima y máxima
| - solo letras, espacios, apóstrofes y guiones
*/
if ($nombre === '') {
    $errores['nombre'] = 'El nombre es obligatorio.';
} elseif (strlen($nombre) < 2) {
    $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
} elseif (strlen($nombre) > 50) {
    $errores['nombre'] = 'El nombre no puede superar 50 caracteres.';
} elseif (!preg_match('/^[\p{L}\s\'-]+$/u', $nombre)) {
    $errores['nombre'] = 'El nombre solo puede contener letras, espacios, apóstrofes y guiones.';
} else {
    // Nombre validado, listo para usar (guardamos tal cual)
    $datosLimpios['nombre'] = $nombre;
}

/*
|--------------------------------------------------------------------------
| 3. Validación del email
|--------------------------------------------------------------------------
| - obligatorio
| - longitud mínima y máxima
| - formato válido con filter_var
*/
if ($email === '') {
    $errores['email'] = 'El email es obligatorio.';
} elseif (strlen($email) < 5) {
    $errores['email'] = 'El email debe tener al menos 5 caracteres.';
} elseif (strlen($email) > 100) {
    $errores['email'] = 'El email no puede superar 100 caracteres.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = 'El email no tiene un formato válido.';
} else {
    $datosLimpios['email'] = $email;
}

/*
|--------------------------------------------------------------------------
| 4. Si hay errores, volver al formulario con errores y old
|--------------------------------------------------------------------------
*/
if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['old'] = $_POST;

    // header('Location: formulario.php');
        http_response_code(422);
        include 'formulario.php';
    exit;
}

/*
|--------------------------------------------------------------------------
| 5. Si todo está bien, guardar en BD
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
| 7. Redirigir al usuario a una página de éxito, un listado,
|    o mostrar un mensaje de confirmación.
|
| 8. Si ocurre un error en la base de datos, capturarlo con try/catch
|    y mostrar un mensaje controlado, sin enseñar detalles técnicos
|    sensibles al usuario final.
*/