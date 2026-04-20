<?php
declare(strict_types=1);

require 'conexion.php';

try {
    $sql = "SELECT id, nombre, email, ciudad, created_at
            FROM contactos ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $contactos = $stmt->fetchAll();
} catch (PDOException $e) {
    // Si es petición AJAX, respondemos con JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Error al obtener los contactos']);
        exit;
    }
    die('Error al obtener los contactos');
}

// Petición AJAX → solo JSON
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => true, 'contactos' => $contactos]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado contactos</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 2rem auto; padding: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>📋 Contactos (<span id="total"><?= count($contactos) ?></span>)</h1>
    <p><a href="index.php">➕ Añadir nuevo contacto</a></p>

    <?php if (empty($contactos)): ?>
        <p id="vacio">📭 No hay contactos aún. ¡Añade el primero!</p>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Ciudad</th><th>Fecha</th></tr>
        </thead>
        <tbody id="tbody-contactos">
            <?php foreach ($contactos as $c): ?>
            <tr>
                <td><?= htmlspecialchars((string)$c['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($c['email'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($c['ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($c['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="contactos.js"></script>
</body>
</html>