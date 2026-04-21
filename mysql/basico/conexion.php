<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Conexión segura y didáctica con MySQL usando PDO
|--------------------------------------------------------------------------
| Objetivos de este archivo:
| 1. Leer las credenciales desde .env
| 2. Validar que todas las claves necesarias existan
| 3. Crear una conexión PDO robusta
| 4. No mostrar detalles técnicos sensibles al usuario final
| 5. Mantener el archivo reutilizable para index.php, guardar.php y listado.php
|--------------------------------------------------------------------------
*/

/**
 * Muestra un mensaje genérico al usuario y detiene la ejecución.
 * En una práctica realista, no conviene enseñar errores técnicos internos.
 */
function abortarConexion(string $mensaje = 'Error interno de conexión con la base de datos.'): never
{
    http_response_code(500);
    exit($mensaje);
}

/**
 * Carga el archivo .env y devuelve sus valores.
 */
$envPath = __DIR__ . '/.env';

if (!is_file($envPath) || !is_readable($envPath)) {
    abortarConexion('Error: no se puede leer el archivo de configuración .env');
}

$dotenv = parse_ini_file($envPath, false, INI_SCANNER_TYPED);

if ($dotenv === false) {
    abortarConexion('Error: el archivo .env no tiene un formato válido');
}

/**
 * Comprobamos que estén todas las claves necesarias.
 */
$clavesRequeridas = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];

foreach ($clavesRequeridas as $clave) {
    if (!array_key_exists($clave, $dotenv)) {
        abortarConexion('Error: falta la variable ' . $clave . ' en el archivo .env');
    }
}

/**
 * Normalizamos y validamos valores mínimos.
 */
$host = trim((string) $dotenv['DB_HOST']);
$database = trim((string) $dotenv['DB_NAME']);
$user = trim((string) $dotenv['DB_USER']);
$password = (string) $dotenv['DB_PASS'];

if ($host === '' || $database === '' || $user === '') {
    abortarConexion('Error: revisa la configuración de conexión en el archivo .env');
}

/**
 * Construimos el DSN.
 */
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
    /*
    |--------------------------------------------------------------------------
    | Importante:
    | No mostramos $e->getMessage() al usuario porque puede revelar:
    | - nombre real de la base de datos
    | - host
    | - usuario
    | - detalles internos del servidor
    |
    | En producción, esto debería registrarse en logs del servidor.
    |--------------------------------------------------------------------------
    */
    abortarConexion();
}