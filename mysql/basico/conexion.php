<?php
declare(strict_types=1);

$dotenv = parse_ini_file(__DIR__ . '/.env');

if ($dotenv === false) {
    die('Error: no se pudo leer el archivo .env');
}

$requiredKeys = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];

foreach ($requiredKeys as $key) {
    if (!array_key_exists($key, $dotenv)) {
        die("Error: falta la variable {$key} en .env");
    }
}

try {
    $dsn = "mysql:host={$dotenv['DB_HOST']};dbname={$dotenv['DB_NAME']};charset=utf8mb4";

    $pdo = new PDO($dsn, $dotenv['DB_USER'], $dotenv['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Error conexión: " . $e->getMessage());
}
?>