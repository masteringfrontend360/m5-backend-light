<?php
declare(strict_types=1);

require 'conexion.php';

// Cabecera JSON siempre, incluso en errores
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

// Validaciones — ahora devuelven JSON en vez de die()
if ($nombre === '' || $email === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Faltan campos obligatorios']);
    exit;
}

if (mb_strlen($nombre) > 100) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'El nombre no puede superar 100 caracteres']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'El email no es válido']);
    exit;
}

if (mb_strlen($ciudad) > 50) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'La ciudad no puede superar 50 caracteres']);
    exit;
}

try {
    $sql = "INSERT INTO contactos (nombre, email, ciudad) VALUES (:nombre, :email, :ciudad)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => $nombre, ':email' => $email, ':ciudad' => $ciudad]);

    // Devolvemos el ID del nuevo registro para que JS pueda añadirlo a la tabla
    echo json_encode(['ok' => true, 'id' => (int) $pdo->lastInsertId()]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    $mensaje = ($e->errorInfo[1] === 1062)
        ? 'Ya existe un contacto con ese email'
        : 'Error al guardar el contacto';
    echo json_encode(['ok' => false, 'error' => $mensaje]);
    exit;
}