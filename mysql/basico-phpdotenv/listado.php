<?php
declare(strict_types=1);

require 'conexion.php';

try {
    $sql = "SELECT id, nombre, email, ciudad
            FROM usuarios
            ORDER BY id DESC";

    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll();

} catch (PDOException $e) {
    die('Error al obtener los usuarios');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado usuarios</title>
</head>
<body>

<h1>📋 Contactos (<?= count($usuarios) ?>)</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">✅ Usuario guardado correctamente</p>
<?php endif; ?>

<a href="index.php">➕ Añadir usuario</a>

<?php if (empty($usuarios)): ?>
    <p>No hay usuarios</p>
<?php else: ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Ciudad</th>
    </tr>

    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars((string)$usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= htmlspecialchars($usuario['ciudad'] ?? '') ?></td>
        </tr>
    <?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>