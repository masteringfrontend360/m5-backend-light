<?php
session_start();

// Guardamos un mensaje antes de destruir la sesión actual
$mensajeLogout = 'Has cerrado sesión correctamente.';

// Vaciar todas las variables de sesión
$_SESSION = [];

// Si la sesión usa cookie, también la eliminamos en el navegador
if (ini_get('session.use_cookies')) {
    $parametros = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 3600,
        $parametros['path'],
        $parametros['domain'],
        $parametros['secure'],
        $parametros['httponly']
    );
}

// Destruir la sesión actual
session_destroy();

// Arrancamos una nueva sesión breve para poder mostrar un mensaje flash
session_start();
$_SESSION['flash'] = [
    'tipo' => 'ok',
    'mensaje' => $mensajeLogout,
];

// Redirigimos al login
header('Location: login.php');
exit;