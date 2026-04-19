<?php
// Cargar variables entorno (.env)
$dotenv = parse_ini_file(__DIR__ . '/.env');

$host = $dotenv['DB_HOST'];
$db = $dotenv['DB_NAME'];
$user = $dotenv['DB_USER'];
$pass = $dotenv['DB_PASS'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", 
                   $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch(PDOException $e) {
    die("❌ Error conexión: " . $e->getMessage());
}
?>