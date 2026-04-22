<?php
declare(strict_types=1);

<<<<<<< HEAD
// Cargar variables de entorno
$dotenv = parse_ini_file(__DIR__ . '/.env');

// Comprueba si .env se ha leído correctamente antes de usarlo.
if ($dotenv === false) {
    die('Error: no se pudo leer el archivo .env');
}

// Verifica que existan todas las claves necesarias
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
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4"; //dsn = data server name - es la cadena de conexión que se utiliza para establecer la conexión con la base de datos MySQL a través de PDO. Incluye el tipo de base de datos (mysql), el host, el nombre de la base de datos y el conjunto de caracteres.

    $pdo = new PDO($dsn, $user, $pass, [ //que es PDO? PHP Data Objects (PDO) es una extensión de PHP que proporciona una interfaz de acceso a bases de datos. Permite a los desarrolladores interactuar con diferentes sistemas de gestión de bases de datos (DBMS) utilizando una API común, lo que facilita la portabilidad del código entre diferentes bases de datos.
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //que es PDO::ATTR_ERRMODE? Es una constante de la clase PDO que se utiliza para configurar el modo de manejo de errores en las operaciones de base de datos. Al establecerlo en PDO::ERRMODE_EXCEPTION, se indica que cualquier error que ocurra durante las operaciones de base de datos lanzará una excepción (PDOException), lo que permite manejar los errores de manera más estructurada y controlada.
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //que es PDO::ATTR_DEFAULT_FETCH_MODE? Es una constante de la clase PDO que se utiliza para configurar el modo de recuperación de datos por defecto en las operaciones de consulta a la base de datos. Al establecerlo en PDO::FETCH_ASSOC, se indica que los resultados de las consultas se devolverán como un array asociativo, donde las claves del array corresponden a los nombres de las columnas de la tabla.
        PDO::ATTR_EMULATE_PREPARES   => false, //que es PDO::ATTR_EMULATE_PREPARES? Es una constante de la clase PDO que se utiliza para configurar si se deben emular las sentencias preparadas en el lado del cliente o si se deben utilizar las sentencias preparadas nativas del servidor de base de datos. Al establecerlo en false, se indica que se deben utilizar las sentencias preparadas nativas del servidor, lo que puede mejorar la seguridad y el rendimiento al evitar la emulación de sentencias preparadas en el lado del cliente.
=======
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();

$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4"; // dsn - Data Server Name

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
>>>>>>> origin/delia
    ]);
} catch (PDOException $e) {
    die("Error conexión: " . $e->getMessage());
    //die('Error de conexión con la base de datos'); // Producción: Evita mostrar al usuario el mensaje técnico completo de la excepción, porque puede exponer detalles internos del sistema
<<<<<<< HEAD
} // que hace catch (PDOException $e)? El bloque catch captura cualquier excepción de tipo PDOException que pueda ocurrir durante la ejecución del bloque try. Si se produce una excepción, el código dentro del bloque catch se ejecutará, permitiendo manejar el error de manera controlada. En este caso, se muestra un mensaje de error específico para problemas de conexión a la base de datos, y se detiene la ejecución del script con die().
=======
}
>>>>>>> origin/delia
?>