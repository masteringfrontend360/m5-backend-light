# Práctica · Primera base de datos con MySQL y conexión básica con PHP

## Objetivo

Crear una pequeña aplicación web sobre LAMP en WSL y Debian capaz de guardar y mostrar información usando PHP y MySQL.

## Contexto

Hasta ahora hemos trabajado con PHP como lenguaje del lado del servidor y hemos visto cómo procesar lógica y mezclar PHP con HTML. En esta práctica vamos a dar el siguiente paso: persistir datos en una base de datos real.

La meta no es profundizar todavía en SQL avanzado ni en diseño complejo de bases de datos. La meta es entender el flujo completo:

HTML → PHP → MySQL → PHP → HTML

## Qué vas a construir

Una mini aplicación de contactos o alumnos con dos pantallas:

- Una página con formulario para añadir un registro.
- Una página para listar los registros guardados.

## Requisitos

- Trabajar en WSL con Debian y stack LAMP con phpMyAdmin instalado.
- Crear una base de datos propia para la práctica.
- Crear una tabla con una estructura simple.
- Insertar registros desde PHP a partir de un formulario.
- Consultar registros desde PHP y mostrarlos en HTML.

## Estructura mínima recomendada

- `index.php` para mostrar el formulario.
````
basico/
├── .env              ← Credenciales seguras
├── conexion.php      ← PDO + .env
├── index.php         ← Formulario
├── guardar.php       ← INSERT preparado
├── listado.php       ← SELECT preparado
└── composer.json     ← (Opcional hoy)
````

## Tareas

- Crear la base de datos.
- Crear la tabla.
- Insertar al menos 3 registros manualmente desde MySQL para comprobar que todo funciona.
- Crear el formulario HTML.
- Recoger los datos enviados con PHP.
- Conectar PHP con MySQL.
- Insertar los datos en la tabla.
- Mostrar un mensaje de éxito o redirigir tras guardar.
- Consultar los registros guardados.
- Pintarlos en una tabla HTML.


## Base de datos

Crea una base de datos para el proyecto: `curso_mysql`

Dentro crea una tabla llamada `contactos` con una estructura similar a esta:

- `id`
- `nombre`
- `email`
- `ciudad`
- `created_at`

```sql
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    ciudad VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
> `UNIQUE` en `email` garantiza que no haya dos contactos con el mismo correo, aunque en PHP olvidemos la validación.
Insertar al menos 3 registros de prueba


##  Paso 1: `.env` (variables entorno)
```ini
DB_HOST=localhost
DB_NAME=curso_mysql
DB_USER=root
DB_PASS=tu_contraseña_mysql
```

Crear fichero .gitignore básico
```text
.env
```

## Paso 2: `conexion.php`
```php
<?php
declare(strict_types=1);

// Cargar variables de entorno
$dotenv = parse_ini_file(__DIR_- . '/.env');

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
```
## Paso 3: `index.php` (formulario)
```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir contacto</title>
     <style>
        body {
            font-family: sans-serif;
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
        }

        input, button {
            font: inherit;
            padding: 0.5rem;
        }

        input {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        p {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <h1>📧 Añadir contacto</h1>
    
    <form action="guardar.php" method="POST" novalidate>
         <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required maxlength="100">
        </p>

        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required maxlength="100">
        </p>

        <p>
            <label for="ciudad">Ciudad:</label><br>
            <input type="text" id="ciudad" name="ciudad" maxlength="50">
        </p>

        <button type="submit">💾 Guardar contacto</button>
    </form>

    <p><a href="listado.php">📋 Ver todos los contactos</a></p>
</body>
</html>
```
## Paso 4: `guardar.php` (INSERT preparado)
```php
<?php
declare(strict_types=1);

require 'conexion.php';

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Método no permitido');
}

// Recoger y limpiar datos
$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');

// Comprobar campos obligatorios
if ($nombre === '' || $email === '') {
    http_response_code(400);
    die('Faltan campos obligatorios');
}

// Validar nombre
if (mb_strlen($nombre) > 100) {
    die('El nombre no puede superar 100 caracteres');
}

// Validar email
if (mb_strlen($email) > 100) {
    die('El email no puede superar 100 caracteres');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('El email no es válido');
}

// Validar ciudad
if (mb_strlen($ciudad) > 50) {
    die('La ciudad no puede superar 50 caracteres');
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
    http_response_code(500);
    echo '❌ Error al guardar el contacto';

     // Código de error 1062 = entrada duplicada en MySQL
    // if ($e->errorInfo[1] === 1062) {
    //     echo '❌ Ya existe un contacto con ese email';
    // } else {
    //     echo '❌ Error al guardar el contacto';
    // }
}
?>
```
## Paso 5: `listado.php` (SELECT)
```php
<?php
declare(strict_types=1);

require 'conexion.php';

try {
    $sql = "SELECT id, nombre, email, ciudad, created_at
            FROM contactos
            ORDER BY created_at DESC";

    $stmt = $pdo->query($sql);
    $contactos = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Error al obtener los contactos');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado contactos</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <h1>📋 Contactos (<?= count($contactos) ?>)</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
        <p class="success">✅ Contacto guardado correctamente</p>
    <?php endif; ?>

    <p><a href="index.php">➕ Añadir nuevo contacto</a></p>

    <?php if (empty($contactos)): ?>
        <p>📭 No hay contactos aún. ¡Añade el primero!</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Ciudad</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactos as $contacto): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $contacto['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($contacto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($contacto['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($contacto['ciudad'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($contacto['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
```
## Versión AJAX
Haz basico-ajax/ aplicando [validación de formularios con AJAX]( https://github.com/masteringfrontend360/m5-backend-light/tree/main/php-fundamentos/07-validacion-formularios/02-con-ajax)

## Aprendizajes que deberías haber obtenido
- Flujo completo persistencia: $_POST → PDO → INSERT → MySQL → SELECT → htmlspecialchars() → HTML.

- Variables entorno: .env mantiene credenciales fuera del código y Git.

- PDO + prepared statements: :nombre evita SQL injection automáticamente.

- Escapar salida: htmlspecialchars() siempre al mostrar datos de DB en HTML.

- Buenas prácticas: trim(), ?? '', header("Location:") tras POST, empty() para listas.

- Diferencia clave: variables PHP son temporales, base de datos es persistente.

- Preparación WordPress: wp-config.php ≈ .env, consultas preparadas, esc_html() ≈ htmlspecialchars().

- Estructura modular: conexion.php reutilizable, separación responsabilidades.

- Debugging: PDO::ATTR_ERRMODE, mensajes de error específicos.

- Estado vacío: mostrar mensaje útil cuando empty($contactos)

