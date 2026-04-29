# Práctica: Catálogo y carrito con clases en PHP

## Objetivo

- Convertir una pequeña lógica de tienda en una mini aplicación orientada a objetos
- Consolidar clases, objetos, propiedades, métodos, constructor, `this` y visibilidad
- Reutilizar lo que ya hemos trabajado de formularios, sesiones, arrays, funciones y PDO
- Dejar preparada la base para la siguiente sesión sobre POO avanzada

## Contexto

- Hasta ahora hemos trabajado muchas piezas del backend por separado: formularios, validación, sesiones, funciones reutilizables, PDO y organización del proyecto
- En esta práctica vamos a dar el siguiente paso: agrupar datos y comportamiento dentro de clases que representen entidades reales de una tienda
- No se trata de hacer POO “porque sí”, sino de usarla para que el código quede más claro, más reutilizable y más fácil de mantener

## Qué vas a construir

- Una mini aplicación PHP con un catálogo de productos y un carrito de compra simple
- El usuario podrá ver productos, añadirlos al carrito y consultar un resumen con cantidades y total
- La lógica principal deberá estar organizada con clases, no con arrays y funciones sueltas repartidas por todo el proyecto

## Requisitos funcionales

- Mostrar un listado de productos
- Permitir añadir un producto al carrito desde un formulario
- Guardar el carrito en sesión
- Mostrar el contenido actual del carrito
- Calcular el total del carrito
- Evitar añadir cantidades no válidas
- Evitar añadir más unidades de las disponibles en stock
- Mostrar mensajes claros de error o éxito

## Clases mínimas obligatorias

- `Producto`: representa un producto del catálogo
- `Carrito`: representa el carrito actual y su lógica principal

## Qué debe tener cada clase

### Clase `Producto`

- Propiedades mínimas: `id`, `nombre`, `precio`, `stock`
- Constructor para inicializar el objeto desde el principio
- Método para comprobar si hay stock suficiente
- Método para devolver el precio formateado
- Método para devolver un resumen corto del producto si lo necesitas

### Clase `Carrito`

- Debe almacenar los productos añadidos con su cantidad
- Método para añadir producto
- Método para eliminar producto o reducir cantidad
- Método para calcular el total
- Método para devolver el número total de unidades
- Método para vaciar el carrito si quieres añadir esta mejora
- La lógica del carrito debe validar cantidades antes de modificar el estado

## Persistencia del carrito

- El carrito debe mantenerse entre peticiones usando `$_SESSION`
- Puedes decidir cómo guardar la información en sesión, pero al volver a cargar la página el carrito debe seguir existiendo
- No metas directamente toda la lógica de sesión en las vistas
- Intenta que la clase `Carrito` siga teniendo una responsabilidad clara

## Datos de productos

- Puedes resolverlo de una de estas dos formas

- Opción A, más sencilla: crear un array inicial de productos y convertir cada elemento en un objeto `Producto`
- Opción B, más útil: leer los productos desde una base de datos con PDO reutilizando lo trabajado en clases anteriores

## Organización recomendada

- `public/index.php` como punto de entrada
- `public/carrito.php` para mostrar el resumen si decides separarlo
- `src/Producto.php`
- `src/Carrito.php`
- `src/helpers.php` si necesitas funciones auxiliares
- `config/` o archivo de configuración si reutilizas base de datos
- `vendor/` y `.env` solo si vienes del proyecto con Composer

## Requisitos técnicos

- Usar PHP en entorno LAMP sobre WSL y Debian
- Crear un ficher README.md con las anotaciones y pasos que vas dando (fundamental)
- Separar HTML y lógica todo lo posible
- Cada clase en su propio archivo
- Nombres de clases en PascalCase
- No mezclar en la misma clase HTML, SQL, validación, sesión y cálculo de totales
- Usar al menos una propiedad `private`
- Usar `this` correctamente dentro de métodos
- Usar constructor al menos en la clase `Producto`

## Flujo mínimo esperado

- Cargar productos
- Crear objetos `Producto`
- Pintar el catálogo en HTML
- Enviar un formulario para añadir un producto
- Recuperar o construir el carrito actual desde sesión
- Añadir el producto validando cantidad y stock
- Guardar el carrito actualizado
- Mostrar resumen del carrito y total

## Mejoras opcionales

- Crear una clase `ProductoRepository` para separar la carga de productos
- Crear una clase `SessionCartStorage` para encapsular la sesión
- Añadir acción de vaciar carrito
- Añadir acción de eliminar una línea del carrito
- Añadir cálculo de IVA
- Añadir validación de mensajes flash en sesión
- Cargar clases automáticamente con Composer y PSR-4
- Preparar el código para soportar distintos tipos de producto más adelante

## Pistas de diseño

- `Producto` debe representar una entidad
- `Carrito` debe encargarse del estado y las operaciones del carrito
- Si notas que una clase empieza a hacer demasiadas cosas, probablemente toca dividir responsabilidades
- Si repites lógica entre clases o piensas “esto podría comportarse distinto según el tipo”, apunta esa idea: seguramente te estará preparando para la siguiente sesión


## Ampliación para enlazar con la siguiente clase

- Piensa qué pasaría si la tienda tuviera productos físicos y productos digitales
- Ambos comparten parte de la información, pero no se comportan exactamente igual
- No hace falta resolverlo todavía, pero deja anotado cómo reorganizarías tu código para soportar ese caso