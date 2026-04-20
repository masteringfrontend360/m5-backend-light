# Práctica: sustituir parse_ini_file por phpdotenv

## Objetivo

- Partir del proyecto básico de la lección anterior donde se cargaban credenciales con `parse_ini_file()`.
- Duplicar la carpeta del proyecto.
- Instalar Composer y la librería `vlucas/phpdotenv`.
- Sustituir la carga nativa del archivo `.env` por la carga con Composer y `phpdotenv`.
- Mantener la conexión PDO funcionando correctamente.

## Qué vas a practicar

- Uso básico de Composer en un proyecto PHP. 
- Instalación de una dependencia real con `composer require`.
- Carga de variables de entorno con `Dotenv\Dotenv::createImmutable()`. 
- Uso de `vendor/autoload.php` para aprovechar el autoload de Composer. 
- Buenas prácticas con `.env`, `.gitignore` y `vendor/`. 

## Requisitos previos

- Tener disponible el proyecto de la práctica anterior de MySQL básico.
- Tener PHP funcionando en WSL con Debian.
- Tener Composer instalado globalmente. 

## Pasos

- Duplica la carpeta del proyecto anterior y renómbrala, por ejemplo, como `basico-dotenv`.
- Entra en la carpeta duplicada desde terminal.
- Instala la librería con este comando:

```bash
composer require vlucas/phpdotenv
```

- Comprueba que ahora existen `composer.json`, `composer.lock` y la carpeta `vendor/`

## Archivo .env

- Crea un archivo `.env` en la raíz del proyecto.
- Usa este contenido como ejemplo:

```env
DB_HOST=localhost
DB_NAME=cursomysql
DB_USER=root
DB_PASS=tu_password
```

- Este formato `CLAVE=VALOR` es el habitual en `phpdotenv` y permite separar configuración y código.

## Código de conexion.php

- Sustituye el uso anterior de `parse_ini_file()` por este patrón:

```php
<?php

declare(strict_types=1);

require __DIR_- . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

// Data Source Name. Información de la conexión
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    ...
```

- La librería recomienda cargar el autoload de Composer y después llamar a `Dotenv::createImmutable()` apuntando al directorio donde está el archivo `.env`. [https://github.com/vlucas/phpdotenv/blob/master/README.md]
- Tras hacer `load()`, las variables quedan disponibles en `$_ENV` y también pueden validarse si el proyecto lo necesita.

## Qué debes cambiar respecto al proyecto anterior

- Eliminar la línea donde se usaba `parse_ini_file(__DIR_- . '/.env')`.
- Cargar `vendor/autoload.php`.
- Inicializar `phpdotenv`.
- Leer las variables desde `$_ENV`.
- Mantener el resto de la conexión PDO igual.

## .gitignore

- Asegúrate de ignorar estos elementos:

```gitignore
.env
/vendor/
```

- `.env` no debe subirse al repositorio porque contiene datos sensibles. 
- `vendor/` tampoco debe subirse porque Composer puede reconstruirla con `composer install`. 

## Comprobación final

- El proyecto conecta correctamente con la base de datos.
- La conexión sigue funcionando tras sustituir `parse_ini_file()`.
- El archivo `.env` está fuera de Git.
- La carpeta `vendor/` está fuera de Git.
- Si otra persona clona el proyecto, podrá ejecutar `composer install`, crear su propio `.env` y ponerlo en marcha. 



## Idea clave

- Antes cargábamos configuración con una solución nativa simple.
- Ahora damos el paso a una solución estándar de proyectos PHP modernos.
- El objetivo no es solo “que funcione”, sino trabajar con una estructura más profesional.