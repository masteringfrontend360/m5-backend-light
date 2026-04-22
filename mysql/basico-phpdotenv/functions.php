<?php
function saveContact(PDO $pdo, string $nombre, string $email, string $ciudad): bool {
    try {
        $sql = "INSERT INTO contactos (nombre, email, ciudad) VALUES (:nombre, :email, :ciudad)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email'  => $email,
            ':ciudad' => $ciudad
        ]);
        return true;
    } catch (PDOException $e) {
        // Manejo básico de errores: registra el error y retorna false
        error_log("Error al guardar contacto: " . $e->getMessage());
        return false;
    }
}