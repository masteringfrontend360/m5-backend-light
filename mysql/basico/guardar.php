<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/conexion.php';

/*
|--------------------------------------------------------------------------
| Procesador seguro y didáctico del formulario
|--------------------------------------------------------------------------
| Este archivo:
| 1. Solo acepta peticiones POST
| 2. Verifica el token CSRF
| 3. Limpia, normaliza y valida los datos
| 4. Usa PDO con sentencia preparada
| 5. Usa mensajes flash para volver al formulario o ir al listado
|--------------------------------------------------------------------------
*/

/**
 * Guarda mensaje flash y redirige.
 */
function redirigirConFlash(string $url, string $tipo, string $mensaje, array $old = []): never
{
    $_SESSION['flash_contactos'] = [
        'tipo' => $tipo,
        'mensaje' => $mensaje,
    ];

    if (!empty($old)) {
        $_SESSION['old_contactos'] = $old;
    }

    header('Location: ' . $url);
    exit;
}

/**
 * Devuelve true si el token CSRF es válido.
 */
function csrfValido(?string $tokenRecibido, ?string $tokenSesion): bool
{
    if (!is_string($tokenRecibido) || $tokenRecibido === '') {
        return false;
    }

    if (!is_string($tokenSesion) || $tokenSesion === '') {
        return false;
    }

    return hash_equals($tokenSesion, $tokenRecibido);
}

/**
 * Normaliza texto básico:
 * - trim
 * - espacios múltiples a uno solo
 */
function normalizarTexto(string $valor): string
{
    $valor = trim($valor);
    $valor = preg_replace('/\s+/u', ' ', $valor) ?? $valor;

    return $valor;
}

// Solo permitimos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

// Comprobación CSRF
$tokenRecibido = $_POST['csrf_token'] ?? null;
$tokenSesion = $_SESSION['csrf_token_contactos'] ?? null;

if (!csrfValido(is_string($tokenRecibido) ? $tokenRecibido : null, is_string($tokenSesion) ? $tokenSesion : null)) {
    redirigirConFlash(
        'index.php',
        'error',
        'La solicitud no es válida o la sesión del formulario ha expirado.'
    );
}

// Recoger y normalizar datos
$nombre = normalizarTexto((string) ($_POST['nombre'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$email = mb_strtolower($email, 'UTF-8');
$ciudad = normalizarTexto((string) ($_POST['ciudad'] ?? ''));

// Guardamos valores para poder repintar el formulario si hay error
$old = [
    'nombre' => $nombre,
    'email' => $email,
    'ciudad' => $ciudad,
];

$errores = [];

// Obligatorios
if ($nombre === '') {
    $errores[] = 'El nombre es obligatorio.';
}

if ($email === '') {
    $errores[] = 'El email es obligatorio.';
}

// Longitudes
if (mb_strlen($nombre) > 100) {
    $errores[] = 'El nombre no puede superar los 100 caracteres.';
}

if (mb_strlen($email) > 100) {
    $errores[] = 'El email no puede superar los 100 caracteres.';
}

if ($ciudad !== '' && mb_strlen($ciudad) > 50) {
    $errores[] = 'La ciudad no puede superar los 50 caracteres.';
}

// Formato email
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El formato del email no es válido.';
}

// Reglas suaves de texto para mantener la práctica limpia
if ($nombre !== '' && !preg_match('/^[\p{L}\p{M}\s\'\-\.]+$/u', $nombre)) {
    $errores[] = 'El nombre contiene caracteres no permitidos.';
}

if ($ciudad !== '' && !preg_match('/^[\p{L}\p{M}\s\'\-\.]+$/u', $ciudad)) {
    $errores[] = 'La ciudad contiene caracteres no permitidos.';
}

// Si hay errores, volvemos al formulario
if (!empty($errores)) {
    redirigirConFlash(
        'index.php',
        'error',
        implode(' ', $errores),
        $old
    );
}

try {
    $sql = 'INSERT INTO contactos (nombre, email, ciudad)
            VALUES (:nombre, :email, :ciudad)';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':ciudad' => $ciudad !== '' ? $ciudad : null,
    ]);

    // Rotamos el token para el siguiente envío
    $_SESSION['csrf_token_contactos'] = bin2hex(random_bytes(32));

    redirigirConFlash(
        'listado.php',
        'ok',
        'Contacto guardado correctamente.'
    );
} catch (PDOException $e) {
    /*
    |--------------------------------------------------------------------------
    | No exponemos detalles técnicos al usuario.
    | Si el email está duplicado, usamos un mensaje neutro.
    |--------------------------------------------------------------------------
    */
    if (isset($e->errorInfo[1]) && (int) $e->errorInfo[1] === 1062) {
        redirigirConFlash(
            'index.php',
            'error',
            'No se ha podido guardar el contacto con los datos enviados.',
            $old
        );
    }

    redirigirConFlash(
        'index.php',
        'error',
        'Ha ocurrido un error interno al guardar el contacto. Inténtalo de nuevo.',
        $old
    );
}