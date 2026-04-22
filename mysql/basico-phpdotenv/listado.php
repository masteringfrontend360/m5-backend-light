<?php
declare(strict_types=1);

require 'conexion.php';

try {
    $sql = "SELECT id, nombre, email, ciudad, created_at
            FROM contactos
            ORDER BY created_at DESC";

    $stmt = $pdo->query($sql);
    $contactos = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Error al obtener los contactos');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado contactos</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>📋 Contactos (<?= count($contactos) ?>)</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
        <p class="success">✅ Contacto guardado correctamente</p>
    <?php endif; ?>

    <p><a href="index.php">➕ Añadir nuevo contacto</a></p>

    <?php if (empty($contactos)): ?>
        <p>📭 No hay contactos aún. ¡Añade el primero!</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Ciudad</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactos as $contacto): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $contacto['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($contacto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($contacto['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($contacto['ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($contacto['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>

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