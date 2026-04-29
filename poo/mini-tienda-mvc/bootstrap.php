<?php

declare(strict_types=1);



spl_autoload_register(function (string $class): void {
    $basePath = __DIR__ . '/app/';
    $prefix = 'App\\';

    if (strpos($class, $prefix) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $basePath . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

session_start();