<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Conexión segura y didáctica con MySQL usando phpdotenv + PDO
|--------------------------------------------------------------------------
| Objetivos de este archivo:
| 1. Cargar variables de entorno con vlucas/phpdotenv
| 2. Validar que existan las claves necesarias
| 3. Crear una conexión PDO robusta
| 4. No exponer detalles técnicos al usuario final
|--------------------------------------------------------------------------
*/

/**
 * Muestra un mensaje genérico al usuario y detiene la ejecución.
 */
function abortarConexion(string $mensaje = 'Error interno de conexión con la base de datos.'): never
{
    http_response_code(500);
    exit($mensaje);
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
$envPath = __DIR__ . '/.env';

if (!is_file($autoloadPath) || !is_readable($autoloadPath)) {
    abortarConexion('Error: no se puede cargar el autoload de Composer. Ejecuta composer install o composer require.');
}

if (!is_file($envPath) || !is_readable($envPath)) {
    abortarConexion('Error: no se puede leer el archivo de configuración .env');
}

require $autoloadPath;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();
} catch (Throwable $e) {
    abortarConexion('Error: la configuración del archivo .env no es válida.');
}

$host = trim((string) ($_ENV['DB_HOST'] ?? ''));
$database = trim((string) ($_ENV['DB_NAME'] ?? ''));
$user = trim((string) ($_ENV['DB_USER'] ?? ''));
$password = (string) ($_ENV['DB_PASS'] ?? '');

if ($host === '' || $database === '' || $user === '') {
    abortarConexion('Error: revisa la configuración de conexión en el archivo .env');
}

$dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";

try {
    $pdo = new PDO(
        $dsn,
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    abortarConexion();
}