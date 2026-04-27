<?php

define('BASE_URL', '/m5-backend-light/poo/mvc-enrutamiento/public/');

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace(BASE_URL, '', $path);
$url = trim($url, '/');


$routes = require '../app/routes.php';



if (array_key_exists($url, $routes)) {
    require $routes[$url];
    exit;
}

http_response_code(404);
echo '<h1>404</h1><p>Página no encontrada</p>';

