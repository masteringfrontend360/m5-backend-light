<?php
require 'conexion.php';

// SELECT preparado
$sql = "SELECT * FROM contactos ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$contactos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado contactos</title>
    <style>
        body{font-family:sans-serif;max-width:800px;margin:2rem auto;padding:1rem;}
        table{width:100%;border-collapse:collapse;margin-top:20px;}
        th,td{padding:12px;border:1px solid #ddd;text-align:left;}
        th{background:#f5f5f5;font-weight:bold;}
        .success{color:green;font-weight:bold;}
    </style>
</head>
<body>
    <h1>📋 Contactos (<?= count($contactos) ?>)</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <p class="success">✅ Contacto guardado correctamente</p>
    <?php endif; ?>
    
    <p><a href="index.php">➕ Añadir nuevo contacto</a></p>
    
    <?php if (empty($contactos)): ?>
        <p style="text-align:center;color:#666;padding:4rem;">
            📭 No hay contactos aún. ¡Añade el primero!
        </p>
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
                        <td><?= htmlspecialchars($contacto['id']) ?></td>
                        <td><?= htmlspecialchars($contacto['nombre']) ?></td>
                        <td><?= htmlspecialchars($contacto['email']) ?></td>
                        <td><?= htmlspecialchars($contacto['ciudad']) ?></td>
                        <td><?= date('d/m H:i', strtotime($contacto['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>