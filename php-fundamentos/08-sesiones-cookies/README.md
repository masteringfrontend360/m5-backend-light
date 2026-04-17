
# **Práctica Sesiones y Cookies PHP**

**Objetivo**: Implementar login con sesión, carrito temporal y preferencias con cookies. Usar `output_buffering` para evitar errores de cabeceras.

**Entorno**: WSL/Debian con LAMP. Carpeta `practica-sesiones/`.

## **📁 Estructura de archivos**

`textpractica-sesiones/
├── index.php          # Login + panel principal
├── carrito.php        # Ver/manipular carrito
├── login.php          # Formulario login
├── logout.php         # Cerrar sesión
├── preferencias.php   # Configurar cookie idioma
└── README.md          # Este archivo`

## **🎯 Ejercicio 1: Sistema de login con sesión**

**Implementar**:

1. `login.php`: formulario email/password (usuarios fijos: `ana@ejemplo.com` / `1234`).
2. `index.php`:
    - Si **no logueado** → redirigir a `login.php`.
    - Si **logueado** → mostrar "Bienvenida, Ana" + enlaces a carrito/preferencias.
3. `logout.php`: `session_destroy()` + redirigir a `index.php`.
4. **Seguridad**: `session_regenerate_id(true)` al hacer login.

**Requisitos**:

- Usar `session_start()` correctamente.
- Validar `$_SESSION['logueado']` con `isset()`.
- `htmlspecialchars()` en todos los `echo`.

**Ejemplo esperado**:

```text
¡Bienvenida Ana!
[Ver carrito] [Preferencias] [Logout]`
````
## **🛒 Ejercicio 2: Carrito con sesión**

**En `carrito.php`**:

1. Inicializar `$_SESSION['carrito'] = []` si no existe.
2. Formulario para añadir producto (nombre + cantidad).
3. Mostrar lista de productos con `count()` y `implode()`.
4. Botón "Vaciar carrito" con `unset($_SESSION['carrito'])`.
5. **Output buffering**: Usar `ob_start()` para añadir item sin "headers already sent".

**Requisitos**:

- Validar que cantidad > 0.
- Mostrar total items.
- Enlace de vuelta a index.

**Ejemplo**:

```text
Carrito (3 items):
• Libro PHP (2)
• Curso JS (1)
[Vaciar] [Volver]`
````
## **🌐 Ejercicio 3: Preferencias con cookies + redirect**

**En `preferencias.php`**:

1. Formulario idioma (ES/EN).
2. Si **cambia** → `setcookie('idioma', $idioma, time()+3600, '/', true, true, 'Lax')` + **redirigir misma página**.
3. Leer `$_COOKIE['idioma'] ?? 'ES'` y mostrar "Idioma: Español".
4. **Output buffering**: `ob_start()` para cambiar sin error.

**Requisitos**:

- Flags modernos: `secure`, `httponly`, `samesite`.
- Validar idioma con `in_array(['ES','EN'])`.
- Mostrar mensaje flash con sesión.

**Ejemplo**:

```text
Idioma actual: Español ✓
[Cambiar a Inglés]
````


## **🔧 Validación obligatoria**

- **Todos los archivos**: `session_start()` al inicio.
- **Todos los echo**: `htmlspecialchars()`.
- **Cookies**: Flags de seguridad.
- **Redirecciones**: `exit;` después de `header()`.


## **💡 Extensiones (opcional)**

- **Mensaje flash** tras login/logout.
- **Contador visitas** con cookie.
- **localStorage** tema oscuro en preferencias (JS puro).

---

# **Práctica Output Buffering**

**Objetivo**: Resolver "headers already sent" con `ob_start()` y redirección.

## **Ejercicio 1: Demo error → solución**

**Crear `debug-headers.php`**:

1. **Bloque 1**: `echo "¡Hola!"` + `session_start()` → **debe fallar**.
2. **Bloque 2**: `ob_start()` → `echo` → `session_start()` → **funciona**.
3. **Bloque 3**: Tu ejemplo cookie + redirect.
4. Mostrar `phpinfo(INFO_SESSION)` al final.

---

# **Práctica Seguridad Sesiones**

**Objetivo**: Implementar `session_regenerate_id()` y validar flags.

## **Ejercicio 1: Login seguro**

Modificar login anterior:

```php
if (login correcto) {
    $_SESSION['logueado'] = true;
    **session_regenerate_id(true);**  // ← ¡AÑADIR!
}
```

**Verificar** en `phpinfo()`:

```text`
session.cookie_httponly → 1
session.cookie_secure → 1`
``

