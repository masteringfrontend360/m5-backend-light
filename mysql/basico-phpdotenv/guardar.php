<?php
declare(strict_types=1);

require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Método no permitido');
}

$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

if ($nombre === '' || $email === '') {
    http_response_code(400);
    die('Faltan campos obligatorios');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Email no válido');
}

try {
    $sql = "INSERT INTO usuarios (nombre, email, ciudad)
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
    http_response_code(500);
    echo '❌ Error al guardar el usuario';
}
?>