<?php
declare(strict_types=1);

require 'conexion.php';

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Método no permitido');
}

// Recoger y limpiar datos
$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

// Comprobar campos obligatorios
if ($nombre === '' || $email === '') {
    http_response_code(400);
    die('Faltan campos obligatorios');
}

// Validar nombre
if (mb_strlen($nombre) > 100) {
    die('El nombre no puede superar 100 caracteres');
}

// Validar email
if (mb_strlen($email) > 100) {
    die('El email no puede superar 100 caracteres');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('El email no es válido');
}

// Validar ciudad
if (mb_strlen($ciudad) > 50) {
    die('La ciudad no puede superar 50 caracteres');
}

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
    // http_response_code(500);
    // echo '❌ Error al guardar el contacto';

    //  Código de error 1062 = entrada duplicada en MySQL
    if ($e->errorInfo[1] === 1062) {
        echo '❌ Ya existe un contacto con ese email';
    } else {
        echo '❌ Error al guardar el contacto';
    }
}
?>