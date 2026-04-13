<!-- ## **Ejercicio 5: Login simple (25-30 min)**

**Objetivo:** Array asociativo + validación + `in_array()` o búsqueda manual.

**Enunciado:**

Crea un formulario de login (usuario + password). 

Define un array `$usuarios` con 3 cuentas válidas (ej: `'admin'=>'1234'`, `'ana'=>'pass123'`, `'invitado'=>'guest'`). 

Al enviar, comprueba si usuario existe **Y** password coincide. Muestra "¡Bienvenido **admin**!" o "Credenciales inválidas".

**💡 Pistas:**

1. Optimiza. No recorras todo el array buscando. Comprueba primero si existe el usuario
2. **¡Seguridad básica!** En producción usa `password_verify()` y hash, pero aquí prioriza lógica.
3. **¡Debug!** `var_dump($_POST);` para ver qué llega.
4. **¡WordPress!** Similar a validar `wp_authenticate()` sin DB. -->