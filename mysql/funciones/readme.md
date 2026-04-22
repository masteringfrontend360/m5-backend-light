1. Funciones de Entrada/Salida y Depuración
echo() / print(): Se utilizan para mostrar texto o variables en el navegador.
var_dump(): Fundamental para depurar; muestra el tipo y valor de una variable (imprescindible para ver qué hay dentro de un array u objeto).
die() / exit(): Detiene la ejecución del script. Muy útil para comprobar errores. 
Deusto Formación
Deusto Formación
 +4
2. Manipulación de Cadenas (Strings)
strlen(): Calcula la longitud de una cadena.
strpos(): Busca la posición de la primera ocurrencia de una subcadena.
substr(): Devuelve parte de una cadena.
trim(): Elimina espacios en blanco (u otros caracteres) del inicio y final de una cadena.
str_replace(): Reemplaza todas las ocurrencias de una cadena buscada con otra cadena. 
GeeksforGeeks
GeeksforGeeks
 +4
3. Manejo de Arrays
count(): Cuenta los elementos de un array.
array_push(): Inserta uno o más elementos al final de un array.
in_array(): Comprueba si un valor existe dentro de un array.
explode(): Divide una cadena en un array mediante un delimitador.
implode(): Une elementos de un array en una cadena. 
Deusto Formación
Deusto Formación
 +2
4. Gestión de Formularios y Seguridad
isset(): Verifica si una variable está definida y no es null.
empty(): Comprueba si una variable está vacía.
htmlspecialchars(): Convierte caracteres especiales en entidades HTML. Crucial para evitar ataques XSS al mostrar datos de usuarios.
header(): Envía un encabezado HTTP, comúnmente usado para redireccionar a otra página (header('Location: inicio.php');). 
Deusto Formación
Deusto Formación
 +4
5. Sesiones y Archivos
session_start(): Inicia una nueva sesión o reanuda la existente.
include() / require(): Incluyen archivos PHP externos (ideal para reutilizar menús, cabeceras o pies de página). 
YouTube
YouTube
 +3
6. Bases de Datos (PDO - Recomendado)
new PDO(): Inicia la conexión a la base de datos.
prepare(): Prepara una sentencia SQL para su ejecución (evita inyección SQL).
execute(): Ejecuta la sentencia preparada.
fetch() / fetchAll(): Obtiene una fila (o todas) de un conjunto de resultados. 
Hostinger
Hostinger
 +1
Aprender estas funciones básicas te permitirá construir aplicaciones dinámicas funcionales sin necesidad de lógica compleja desde cero. 