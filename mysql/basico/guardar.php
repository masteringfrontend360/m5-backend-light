<?php
declare(strict_types=1);

require 'conexion.php';
//diferencia entre require y include: require genera un error fatal (E_COMPILE_ERROR) y detiene la ejecución del script si el archivo no se encuentra o no se puede incluir, mientras que include genera un error de advertencia (E_WARNING) pero permite que el script continúe ejecutándose incluso si el archivo no se encuentra o no se puede incluir. En resumen, require es más estricto y detiene la ejecución en caso de error, mientras que include es más flexible y permite continuar con la ejecución del script.
// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

// Recoger y limpiar datos
$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

// Comprobar campos obligatorios
if ($nombre === '' || $email === '') {
    http_response_code(400);
    exit('Faltan campos obligatorios');
}

// Validar nombre
if (mb_strlen($nombre) > 100) {
    exit('El nombre no puede superar 100 caracteres');
}

// Validar email
if (mb_strlen($email) > 100) {
    exit('El email no puede superar 100 caracteres');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('El email no es válido');
}

// Validar ciudad
if (mb_strlen($ciudad) > 50) {
    exit('La ciudad no puede superar 50 caracteres');
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
    //http_response_code(500);
    //echo $e->getMessage(); // Para desarrollo: muestra el mensaje de error específico de la excepción, lo que puede ayudar a identificar el problema exacto. Sin embargo, ten cuidado al mostrar mensajes de error detallados en producción, ya que pueden revelar información sensible sobre la estructura de la base de datos o la configuración del servidor.
    // echo '❌ Error al guardar el contacto';

     // Código de error 1062 = entrada duplicada en MySQL
    if ($e->errorInfo[1] === 1062) {
        echo '❌ Ya existe un contacto con ese email';
    } else {
        echo $e->getMessage(); // Para desarrollo: muestra el mensaje de error específico de la excepción, lo que puede ayudar a identificar el problema exacto. Sin embargo, ten cuidado al mostrar mensajes de error detallados en producción, ya que pueden revelar información sensible sobre la estructura de la base de datos o la configuración del servidor.
        // echo '❌ Error al guardar el contacto';
    }
}
?>