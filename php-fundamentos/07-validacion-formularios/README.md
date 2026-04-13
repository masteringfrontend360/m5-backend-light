# 📝 Validación de Formularios en PHP  
(01-clasico-sesion + 02-con-ajax)

Esta carpeta muestra cómo validar formularios en **PHP moderno** de forma segura, primero con el enfoque clásico (redirect + sesiones) y luego con **AJAX + JSON**.

---

## 📁 Estructura

```txt
validacion-formularios/
├── 01-clasico-sesion/
│   ├── formulario.php
│   └── proceso.php
└── 02-con-ajax/
    ├── formulario-ajax.html
    └── proceso-ajax.php
```

---

## 🎯 Objetivos didácticos

- Entender la diferencia entre:
  - **validación** (comprobar reglas),
  - **sanitización/normalización** (limpiar/ajustar datos),
  - **escapado de salida** (proteger al mostrar en HTML).
- Ver un flujo completo de formulario:
  1. Recoger datos con `$_POST`.
  2. `trim()` y validaciones (longitud, formato, regex).
  3. Gestión de errores por campo.
  4. UX: repoblar formulario (`old`) y mostrar errores.
- Comparar dos formas de responder desde PHP:
  - HTML clásico con redirección y sesiones.
  - Respuesta **JSON** para peticiones AJAX.

---

## 🧩 Conexión con el temario

- **M1 Fundamentos de PHP Moderno**
  - `trim()`, `strlen()`, `preg_match()`
  - `session_start()` y uso básico de `$_SESSION`
  - `htmlspecialchars()` para evitar XSS al mostrar datos

- **M3 CRUD y Conexión con Formularios**
  - Este ejemplo es la base para:
    - Validar antes de hacer `INSERT/UPDATE`.
    - Reutilizar la misma lógica al guardar en MySQL.

- **M4 JavaScript y AJAX**
  - `02-con-ajax` usa `fetch()` + JSON.
  - PHP devuelve errores en formato JSON (`http_response_code(422)`).
  - El frontend muestra los errores sin recargar la página.

Más adelante, en proyectos reales, esta validación manual se suele sustituir por sistemas de validación más declarativos (Laravel Validation, Symfony Validator, Respect/Validation, etc.), pero aquí se ve primero la “mecánica base”.

---

## 01-clasico-sesion/ (validación clásica)

### Flujo

1. El usuario accede a `formulario.php`.
2. Envía datos a `proceso.php` por `POST`.
3. `proceso.php`:
   - Aplica `trim()` a cada campo.
   - Valida cada campo **por separado**:
     - `nombre`: obligatorio, 2–50 caracteres, solo letras/espacios/apóstrofes/guiones.
     - `email`: obligatorio, 5–100 caracteres, formato email válido (`filter_var()`).
   - Si hay errores:
     - Guarda `$_SESSION['errores']` (mensajes por campo).
     - Guarda `$_SESSION['old'] = $_POST` (lo que el usuario escribió).
     - Redirige a `formulario.php`.
   - Si no hay errores:
     - (En el módulo de CRUD) se conectará a la BD con PDO y se hará el `INSERT` con sentencias preparadas.
4. `formulario.php`:
   - Lee `$_SESSION['errores']` y `$_SESSION['old']` si existen.
   - Muestra los errores bajo cada campo.
   - Rellena los inputs con los valores anteriores.

### Puntos clave de seguridad

- **Normalización de entrada**:
  ```php
  $nombre = trim($_POST['nombre'] ?? '');
  $email  = trim($_POST['email'] ?? '');
  ```
- **Validación de reglas**:
  - Longitud mínima y máxima (`strlen()`).
  - Regex para nombre (solo letras y algunos símbolos).
  - `filter_var($email, FILTER_VALIDATE_EMAIL)` para formato de email.

- **Protección XSS al mostrar datos**:
  - Siempre se usan:
    ```php
    htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')
    ```
    al imprimir cosas que vienen del usuario (valores antiguos y mensajes de error), para que el navegador no interprete etiquetas ni atributos maliciosos.

- **Separación de responsabilidades**:
  - `proceso.php`: valida y decide si hay errores.
  - `formulario.php`: solo se encarga de mostrar formulario + errores.

### `$_SESSION['old'] = $_POST`

**¿Por qué existe `old`?**

- Si falla solo uno de los campos (por ejemplo, el email), no obligamos al usuario a reescribir el nombre.
- Guardamos el `$_POST` original en sesión y repoblamos el formulario con:
  ```php
  value="<?= htmlspecialchars($old['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
  ```
- Así mejoramos la UX sin comprometer la seguridad (todo se escapa al mostrarse).

---

## 02-con-ajax/ (validación con AJAX + JSON)

### Flujo

1. El usuario accede a `formulario-ajax.html`.
2. Envía el formulario con JavaScript:
   - `preventDefault()` para no recargar la página.
   - Envía datos con `fetch('proceso-ajax.php', { method: 'POST', body: FormData })`.
3. `proceso-ajax.php`:
   - Realiza **exactamente la misma validación** que el ejemplo clásico (mismas reglas).
   - Si hay errores:
     - Devuelve `http_response_code(422)`.
     - Devuelve JSON:
       ```json
       {
         "ok": false,
         "errores": {
           "nombre": "...",
           "email": "..."
         }
       }
       ```
   - Si todo está bien:
     - (En el futuro) haría el `INSERT` en BD.
     - Devuelve JSON:
       ```json
       {
         "ok": true,
         "mensaje": "Formulario validado correctamente. Listo para guardar en base de datos."
       }
       ```

4. El JavaScript:
   - Limpia mensajes previos.
   - Si la respuesta trae errores, los muestra bajo cada campo.
   - Si la respuesta es OK, muestra un mensaje y hace `form.reset()`.

### Diferencias respecto al clásico

- No se usa `$_SESSION` para errores ni `old`.
- No hay `header('Location: ...')`.
- La comunicación PHP ↔ JS se hace con **JSON estructurado** y códigos HTTP (`422` para errores de validación).
- El usuario no ve recargas; todo ocurre en la misma vista.

---

## 🔐 Validación manual vs. herramientas reales

En este módulo:

- La validación se hace **a mano**, campo a campo, para entender bien:
  - cómo se limpia la entrada,
  - cómo se construyen los mensajes de error,
  - y cómo se evita XSS al mostrar los datos.

En proyectos reales, se suelen usar:

- **Frameworks** como Laravel o Symfony, que permiten declarar reglas tipo:
  ```php
  'nombre' => 'required|string|min:2|max:50',
  'email'  => 'required|email|max:100',
  ```
  y generan automáticamente los mensajes de error.
- **Librerías de validación** como Respect/Validation para PHP “vanilla”.

Este ejemplo sirve como base conceptual para entender **qué problema se están resolviendo**.

---

## 💡 Resumen 
> “Primero validamos a mano para entender el mecanismo: normalizar → validar → si error, volver con errores y old.

> Luego, en proyectos profesionales, usamos librerías o frameworks para no reescribir esa lógica una y otra vez.”