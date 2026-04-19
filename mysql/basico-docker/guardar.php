<?php
require 'conexion.php';

if ($_POST) {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $ciudad = trim($_POST['ciudad'] ?? '');

    // INSERT preparado (protege contra SQL injection)
    $sql = "INSERT INTO contactos (nombre, email, ciudad) VALUES (:nombre, :email, :ciudad)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':ciudad' => $ciudad
    ])) {
        header("Location: listado.php?success=1");
        exit;
    } else {
        echo "❌ Error al guardar: " . print_r($stmt->errorInfo(), true);
    }
}
?>