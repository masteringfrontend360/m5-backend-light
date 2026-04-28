<?php

/**
 * Configuración de la aplicación
 * 
 * Este archivo centraliza configuraciones que pueden cambiar
 * según el entorno (desarrollo, producción, testing)
 */

// Configuración de base de datos (preparado para futuras evoluciones)
// Si decides usar MySQL, configura aquí

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tienda_poo');

// Configuración de la aplicación

define('APP_NAME', 'Tienda POO');
define('APP_VERSION', '1.0.0');
define('APP_DEBUG', true);

// Configuración de moneda

define('MONEDA', '€');
define('PORCENTAJE_IVA', 21);
define('LOCALIZACION', 'es_ES');

// Configuración de sesión

define('CART_SESSION_KEY', 'carrito');
define('MESSAGE_SESSION_KEY', 'mensaje');
define('MESSAGE_TYPE_SESSION_KEY', 'tipo_mensaje');

// Rutas

define('ROOT_PATH', __DIR__ . '/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('SRC_PATH', ROOT_PATH . 'src/');
define('CONFIG_PATH', ROOT_PATH . 'config/');

// Esto sería para conectar con BD en futuras versiones
/*
function obtenerConexionDB(): PDO {
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (Exception $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}
*/
