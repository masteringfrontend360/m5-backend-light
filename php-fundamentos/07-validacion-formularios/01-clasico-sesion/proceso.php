<?php
session_start();

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

    header('Location: formulario.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| 5. Si todo está bien, preparar mensaje de éxito
|--------------------------------------------------------------------------
*/
$_SESSION['exito'] = 'Formulario validado correctamente. Listo para guardar en base de datos.';
unset($_SESSION['old']);

/*
|--------------------------------------------------------------------------
| 6. Más adelante: conexión con PDO e INSERT
|--------------------------------------------------------------------------
|
| Aquí, en el módulo CRUD, el siguiente paso será:
| - conectar con PDO
| - preparar una consulta INSERT
| - ejecutar la inserción con $datosLimpios
| - controlar errores con try/catch
|
*/
header('Location: formulario.php');
exit;