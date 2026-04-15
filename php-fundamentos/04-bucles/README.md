# Estructuras de repetición

## **while**

**Ejercicio 1.** Mostrar todos los números del 1 al 50, ambos incluidos.

**Ejercicio 2.** Mostrar todos los números impares del 51 al 1, en orden descendente.

**Ejercicio 3.** Dados dos números (`num1` y `num2`), comprobar que `num1 < num2`, mostrar todos los números comprendidos entre ellos y calcular la suma total.

**Ejercicio 4.** Dado un número, indicar si es primo o no.

## **do...while**

**Ejercicio 1.** Mostrar todos los números múltiplos de 15 entre 30 y 75, ambos incluidos.

**Ejercicio 2.** Sumar todos los números impares entre 0 y 10.

**Ejercicio 3.** Mostrar la tabla de multiplicar del 2, del 1 al 10, dentro de una tabla HTML.

## **for**

**Ejercicio 1.** Reescribir alguno de los ejercicios anteriores usando un bucle `for`.

**Ejercicio 2.** Mostrar todas las tablas de multiplicar del 1 al 10 usando dos bucles `for` anidados.

## **foreach**

**Ejercicio 1.** Crear un formulario con campos como nombre, apellidos, email, fecha de nacimiento, dirección, código postal, provincia y comentarios. Al enviar el formulario, recorrer los datos recibidos con `foreach` y mostrar una lista con el nombre de cada campo y su valor.

**Nota.** En PHP, `foreach` se utiliza normalmente para recorrer arrays, por ejemplo un array asociativo como `$_POST`.

## **break / continue**

**Ejercicio 1.** Usar un bucle `for` para encontrar el primer número divisible por 7 entre 1 y 100, y detener la ejecución con `break` al encontrarlo.

**Ejercicio 2.** Usar un bucle `for` para mostrar los números del 1 al 20, saltando los múltiplos de 3 con `continue`.

# Ejercicios prácticos: Arrays y bucles

## **Ejercicio 1: Select de localidades (15-20 min)**

**Objetivo:** Crear y mostrar un array indexado en un `<select>`. Recoger `$_POST` y mostrar resultado.

**Enunciado:**

Crea un formulario con un `<select>` que muestre localidades de Aragón (usa al menos 5: Zaragoza, Huesca, Teruel, Calatayud, Tarazona). El array de localidades debe definirse en PHP. Al enviar, muestra un mensaje como "Has seleccionado: **Zaragoza**".

**💡 Pistas paso a paso:**

1. Define `$localidades= ['Zaragoza', 'Huesca', 'Teruel', ...];` al inicio del archivo PHP.
2. Usa `foreach` para generar las `<option value="...">`.
3. Valida con `$_POST['localidad'] ?? 'Ninguna';`.
4. **¡Prueba!** Accede por `http://localhost/tu-archivo.php` en WSL.

---

## **Ejercicio 2: Catálogo de productos (25-30 min)**

**Objetivo:** Array multidimensional + ordenación + mostrar en HTML.

**Enunciado:**

Crea un array `$productos` con 4 productos (cada uno con `nombre`, `precio`, `stock`, `foto` como URL placeholder tipo `https://placehold.co/300x200?text=Hello+World`).

Muéstralos en tarjetas HTML.

Añade un `<select>` para ordenar por precio (asc/desc). Al enviar, reordena con `usort()` y muestra el catálogo ordenado.

**💡 Pistas:**

1. Estructura: `$productos = [ ['nombre'=>'Camiseta', 'precio'=>19.95, 'stock'=>10, 'foto'=>'url'], ... ];`
2. Tarjeta HTML: `<div class="producto"><img src="..."> <h3>...</h3> <p>€...</p></div>`.
3. Ordena con `if ($_POST['orden'] === 'ASC'){
     usort($productos, function ($a, $b) {
            return $a['precio'] <=> $b['precio'];
        })
}`
4. Este array es lo que devuelve `wc_get_products()`. 
Transición:
**$productos = [ ... ];  →  $productos = wc_get_products(['limit'=>4]);**
5. **¡Prueba!** Usa `echo '<pre>'; print_r($productos); echo '</pre>';` para depurar antes de mostrar.

---

## **Ejercicio 3: Includes + metadatos de sitio (30-40 min)**

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
**<?php
$paginaActual = 'blog';
include 'includes/header.php';
?>**
```

---

## **Ejercicio 4: Checkbox múltiple (20-25 min)**

**Objetivo:** Arrays desde formularios + `$_POST` con corchetes `[]`.

**Enunciado:**

Crea un formulario con **checkbox** para "Habilidades frontend" (HTML, CSS, JS, SEO, WordPress; al menos 5).

Al enviar, recoge el array `$_POST['habilidades']` y muestra: 

"Tus habilidades: **HTML, CSS, WordPress**" (lista con comas).

**💡 Pistas:**

1. Checkbox: `<input type="checkbox" name="habilidades[]" value="HTML">` (¡nota los `[]`!).
2. Recoge: `$habilidades = $_POST['habilidades'] ?? [];`
3. Muestra: `echo implode(', ', $habilidades);`
4. Como checkboxes de "atributos de producto".

---

## **Ejercicio 5: Login simple (25-30 min)**

**Objetivo:** Array asociativo + validación + `in_array()` o búsqueda manual.

**Enunciado:**

Crea un formulario de login (usuario + password). 

Define un array `$usuarios` con 3 cuentas válidas (ej: `'admin'=>'1234'`, `'ana'=>'pass123'`, `'invitado'=>'guest'`). 

Al enviar, comprueba si usuario existe **Y** password coincide. Muestra "¡Bienvenido **admin**!" o "Credenciales inválidas".

**💡 Pistas:**

1. Optimiza. No recorras todo el array buscando. Comprueba primero si existe el usuario
2. **¡Seguridad básica!** En producción usa `password_verify()` y hash, pero aquí prioriza lógica.
3. **¡Debug!** `var_dump($_POST);` para ver qué llega.
4. **¡WordPress!** Similar a validar `wp_authenticate()` sin DB.