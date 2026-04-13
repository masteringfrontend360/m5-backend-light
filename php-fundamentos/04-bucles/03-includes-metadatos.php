<!-- ## **Ejercicio 3: Includes + metadatos de sitio (30-40 min)**

**Objetivo:** Arrays multidimensionales + includes + lógica condicional.

**Enunciado:**

 Crea un pequeño sitio con `index.php`, `blog.php` y `contacto.php`, usando `header.php` y `footer.php`. 

Guarda en un fichero aparte un array con los datos de cada página (`titulo`, `descripcion` y, si quieres, `h1`).

Según la página actual, muestra en el `<title>`, en la meta description y en el encabezado los datos que correspondan.

Cada página accede a su propio dato con  y lo muestra en `<title>`, `<meta description>` y `<h1>`.

**💡 Pistas:**

- Crea un fichero para guardar los datos.
- Dentro, define un array asociativo o multidimensional con la información de cada página.
- Usa una clave como `'index'`, `'blog'` o `'contacto'`.
- En cada página define una variable como `$paginaActual = 'blog'`
Después detectaremos la URL automáticamente
- En `header.php`, carga el fichero de datos y usa `$paginaActual` para acceder a la información correcta.

```php
<?php
$paginaActual = 'blog';
include 'includes/header.php';
?>
``` 

--- -->