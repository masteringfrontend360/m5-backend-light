<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/conexion.php';

/*
|--------------------------------------------------------------------------
| Listado seguro y didáctico de contactos
|--------------------------------------------------------------------------
| Este archivo:
| 1. Consulta los registros guardados en MySQL
| 2. Recupera mensajes flash si existen
| 3. Muestra estado vacío o tabla con resultados
| 4. Escapa siempre la salida antes de pintarla en HTML
|--------------------------------------------------------------------------
*/

$flash = $_SESSION['flash_contactos'] ?? null;
unset($_SESSION['flash_contactos']);

try {
    $sql = 'SELECT id, nombre, email, ciudad, created_at
            FROM contactos
            ORDER BY created_at DESC, id DESC';

    $stmt = $pdo->query($sql);
    $contactos = $stmt->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    $contactos = [];
    $flash = [
        'tipo' => 'error',
        'mensaje' => 'Ha ocurrido un error al obtener los contactos.',
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica MySQL · Listado de contactos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="box">
    <h1>Práctica MySQL · Listado de contactos</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> consultar los registros guardados en MySQL y pintarlos en HTML.</p>
        <p>Este archivo representa la parte final del flujo de persistencia: PHP hace un <code>SELECT</code>, recupera los resultados con PDO y los muestra en una tabla HTML de forma segura.</p>
        <p>Aquí trabajamos el camino completo <strong>MySQL → PHP → HTML</strong>.</p>
    </div>

    <?php if (is_array($flash) && isset($flash['tipo'], $flash['mensaje'])): ?>
        <div class="<?php echo htmlspecialchars((string) $flash['tipo'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars((string) $flash['mensaje'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="acciones">
        <a class="boton-enlace" href="index.php">Añadir nuevo contacto</a>
    </div>

    <div class="mini-box">
        <h2>Resumen rápido</h2>
        <p><strong>Total de contactos:</strong> <?php echo htmlspecialchars((string) count($contactos), ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <?php if (empty($contactos)): ?>
        <div class="warning">
            No hay contactos todavía. Añade el primero desde el formulario.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Ciudad</th>
                    <th>Fecha de creación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactos as $contacto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string) $contacto['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars((string) $contacto['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars((string) $contacto['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars((string) ($contacto['ciudad'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime((string) $contacto['created_at'])), ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>Incluimos <code>conexion.php</code> para reutilizar la conexión PDO.</li>
            <li>Ejecutamos un <code>SELECT</code> sobre la tabla <code>contactos</code>.</li>
            <li>Recogemos todos los resultados con <code>fetchAll()</code>.</li>
            <li>Si no hay registros, mostramos un estado vacío útil.</li>
            <li>Si sí hay datos, los pintamos en una tabla HTML.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Buena práctica importante</h2>
        <ul>
            <li>Aunque los datos vengan de nuestra base de datos, los mostramos con <code>htmlspecialchars()</code>.</li>
            <li>Eso ayuda a evitar problemas si algún valor contiene HTML o caracteres especiales.</li>
            <li>En backend, escapar la salida sigue siendo obligatorio.</li>
        </ul>
    </div>
</div>

</body>
</html>