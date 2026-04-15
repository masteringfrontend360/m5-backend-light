<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=UTF-8');

/*
|--------------------------------------------------------------------------
| 1. Normalizar datos de entrada
|--------------------------------------------------------------------------
*/
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');

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
} elseif (strlen($nombre) < 2) {
    $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
} elseif (strlen($nombre) > 50) {
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
| 4. Si hay errores, devolver JSON con código 422
|--------------------------------------------------------------------------
*/
if (!empty($errores)) {
    http_response_code(422);

    echo json_encode([
        'ok' => false,
        'errores' => $errores
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/*
|--------------------------------------------------------------------------
| 5. Si todo está bien, devolver respuesta de éxito
|--------------------------------------------------------------------------
|
| En el módulo CRUD, aquí se conectará con PDO, se hará el INSERT y
| se devolverá un JSON final al frontend.
|
*/
echo json_encode([
    'ok' => true,
    'mensaje' => 'Formulario validado correctamente con AJAX. Listo para guardar en base de datos.'
], JSON_UNESCAPED_UNICODE);