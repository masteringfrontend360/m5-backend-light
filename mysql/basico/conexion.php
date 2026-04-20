<?php
declare(strict_types=1);

// Cargar variables de entorno
$dotenv = parse_ini_file(__DIR__ . '/.env');

// // Comprueba si .env se ha leído correctamente antes de usarlo.
if ($dotenv === false) {
    die('Error: no se pudo leer el archivo .env');
}

// // Verifica que existan todas las claves necesarias
$requiredKeys = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];

foreach ($requiredKeys as $key) {
    if (!array_key_exists($key, $dotenv)) {
        die("Error: falta la variable {$key} en .env");
    }
}

$host = $dotenv['DB_HOST'];
$db   = $dotenv['DB_NAME'];
$user = $dotenv['DB_USER'];
$pass = $dotenv['DB_PASS'];

try {
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Error conexión: " . $e->getMessage());
    //die('Error de conexión con la base de datos'); // Producción: Evita mostrar al usuario el mensaje técnico completo de la excepción, porque puede exponer detalles internos del sistema
}
?>