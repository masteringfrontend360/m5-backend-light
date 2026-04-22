<?php
$dotenv = parse_ini_file(__DIR__ . '/.env');

$host = $dotenv['DB_HOST'];
$port = $dotenv['DB_PORT'];
$db = $dotenv['DB_NAME'];
$user = $dotenv['DB_USER'];
$pass = $dotenv['DB_PASS'];

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => false  // Importante en Docker
        ]
    );
    echo "✅ Conexión OK";
} catch (PDOException $e) {
    die("❌ Error conexión: " . $e->getMessage());
}
?>