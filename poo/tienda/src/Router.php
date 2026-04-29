<?php

namespace App;

class Router
{
    private array $rutas = [];

    public function get(string $ruta, callable $controlador): void
    {
        $this->rutas['GET'][$ruta] = $controlador;
    }

    public function post(string $ruta, callable $controlador): void
    {
        $this->rutas['POST'][$ruta] = $controlador;
    }

    public function despachar(string $metodo, string $uri): void
    {
        // Quitar query string
        $ruta = strtok($uri, '?');

        // Quitar el prefijo del subdirectorio (definido como BASE_URL en index.php)
        $base = defined('BASE_URL') ? BASE_URL : '';
        if ($base !== '' && strpos($ruta, $base) === 0) {
            $ruta = substr($ruta, strlen($base));
        }
        if ($ruta === '' || $ruta === false) {
            $ruta = '/';
        }

        if (isset($this->rutas[$metodo][$ruta])) {
            call_user_func($this->rutas[$metodo][$ruta]);
            return;
        }

        http_response_code(404);
        echo '<h1>404 — Página no encontrada</h1>';
    }
}
