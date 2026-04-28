<?php

/**
 * Autoloader PSR-4 simple para el namespace App\
 * Base: proyecto/src/
 */
spl_autoload_register(function (string $clase): void {
    // Sólo gestionamos nuestro namespace
    if (strpos($clase, 'App\\') !== 0) {
        return;
    }

    $relativo  = substr($clase, strlen('App\\'));           // Models\Producto
    $ruta      = str_replace('\\', DIRECTORY_SEPARATOR, $relativo); // Models/Producto
    $archivo   = __DIR__ . '/../src/' . $ruta . '.php';

    if (file_exists($archivo)) {
        require_once $archivo;
    }
});
