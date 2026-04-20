# 📋 Proceso de Creación - Proyecto basico-nodejs con Fetch API

## 📅 Fecha: 20 de Abril de 2026

---

## 🎯 Objetivo General
Replicar el proyecto PHP `/basico` usando **Node.js + Express + Fetch API** con la misma BD `curso_mysql`.

---

## 📝 Paso a Paso

### **PASO 1: Análisis de la solución actual**
- ✅ Se revisó el proyecto PHP en `/mysql/basico/`
- ✅ Se identificaron 3 archivos clave:
  - `index.php` - Formulario HTML
  - `guardar.php` - INSERT con validaciones
  - `listado.php` - SELECT y listado de contactos
- ✅ Se analizó la estructura de la tabla `contactos`:
  ```sql
  id (INT PRIMARY KEY AUTO_INCREMENT)
  nombre (VARCHAR(100) NOT NULL)
  email (VARCHAR(100) NOT NULL UNIQUE)
  ciudad (VARCHAR(50))
  created_at (TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
  ```

### **PASO 2: Decisión sobre validación**
- **Pregunta:** ¿Es adecuado usar `exit` o mantener `die` en PHP?
- **Decisión:** Cambiar todos los `die()` por `exit()` para coherencia
- **Resultado:** 6 cambios realizados en `guardar.php` PHP

### **PASO 3: Modernizar código PHP (Opcional)**
- Se propusieron mejoras modernas al `listado.php`:
  - Inicializar `$contactos = []` antes del try
  - Usar `error_log()` para registrar errores
  - Agregar `http_response_code(500)` explícito

### **PASO 4: Crear proyecto Node.js base**
Crear carpeta `/basico-nodejs` con estructura inicial:

#### **Archivos creados:**

**`package.json`**
```json
{
  "name": "contactos-app",
  "version": "1.0.0",
  "type": "module",
  "scripts": {
    "start": "node index.js",
    "dev": "node --watch index.js"
  },
  "dependencies": {
    "express": "^4.18.2",
    "mysql2": "^3.6.0",
    "dotenv": "^16.3.1",
    "ejs": "^3.1.x"
  }
}
```

**`.env`**
```
DB_HOST=localhost
DB_NAME=curso_mysql
DB_USER=root
DB_PASS=Hayati1-
DB_PORT=3306
NODE_ENV=development
PORT=3000
```

### **PASO 5: Configurar conexión a MySQL**

**Archivo: `conexion.js`**
- Usar `mysql2/promise` para operaciones async/await
- Crear pool de conexiones
- Cargar variables desde `.env`
- Verificar conexión al iniciar

```javascript
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

export const pool = mysql.createPool(config);
```

### **PASO 6: Crear servidor Express base**

**Archivo: `index.js` - Versión 1**
- Rutas iniciales GET `/` y POST `/guardar`
- Middleware: express.urlencoded, express.static, ejs
- Renderizar vistas EJS

### **PASO 7: Agregar Fetch API (AJAX)**

**Modificaciones a `index.js`:**

1. **Función reutilizable `validarContacto()`**
   - Centralizar lógica de validación (DRY)
   - Retorna `{ valido: boolean, error?: string, nombre, email, ciudad }`

2. **Rutas formulario tradicional:**
   - `POST /guardar` → Redirect (compatibilidad)
   - `GET /listado` → Renderizar EJS

3. **Rutas API JSON (Fetch):**
   - `POST /api/guardar` → Responde JSON
   - `GET /api/contactos` → JSON con todos
   - `DELETE /api/contacto/:id` → Eliminar

### **PASO 8: Crear archivo JavaScript frontend**

**Archivo: `public/js/app.js`**

Funciones principales:

**`guardarContactoFetch(e)`**
- Prevenir submit default
- Hacer POST a `/api/guardar` con JSON
- Renderizar mensaje de éxito/error
- Recargar tabla dinámicamente

**`cargarContactosFetch()`**
- GET a `/api/contactos`
- Procesar JSON
- Llamar a `mostrarContactos()`

**`mostrarContactos(contactos)`**
- Vaciar `<tbody>`
- Iterar y crear `<tr>` por contacto
- Incluir botón eliminar
- Actualizar contador

**`eliminarContactoFetch(id)`**
- DELETE a `/api/contacto/:id}`
- Confirmación con `confirm()`
- Recargar tabla

**Utilidades:**
- `mostrarMensaje()` - Mostrar alertas temporales
- `escapeHtml()` - Sanitizar para XSS

**Inicialización:**
- Agregar listener a formulario si existe
- Cargar contactos si existe tabla

### **PASO 9: Crear vistas EJS**

**`views/index.ejs`**
- Formulario con `id="formulario"`
- Campos: nombre, email, ciudad
- Div `id="mensajes"` para alertas
- Script: `<script src="/js/app.js"></script>`
- Estilos básicos

**`views/listado.ejs`**
- Título con contador dinámico: `<span id="contador-contactos">`
- Tabla con `id="tabla-contactos"`
- Botón "🗑️ Eliminar" por cada contacto
- Div `id="sin-contactos"` para estado vacío
- Script: `<script src="/js/app.js"></script>`
- Estilos mejorados (botones rojos, alertas)

**`views/error.ejs`**
- Mensaje de error
- Enlaces de retorno

### **PASO 10: Actualizar `.env` con BD correcta**

**Cambio en `.env`:**
```
DB_NAME=curso_mysql  ← (era basico_js)
DB_PASS=Hayati1-     ← Contraseña correcta
```

### **PASO 11: Comparativa PHP vs Node.js**

| Aspecto | PHP | Node.js |
|---------|-----|---------|
| **Validación nombre** | `mb_strlen() > 100` | `.length > 100` |
| **Validación email** | `filter_var(...VALIDATE_EMAIL)` | Regex: `/^[^\s@]+@[^\s@]+\.[^\s@]+$/` |
| **Consultas preparadas** | PDO `:nombre` | mysql2 `?` placeholders |
| **Error duplicado** | `$e->errorInfo[1] === 1062` | `err.code === 'ER_DUP_ENTRY'` |
| **INSERT** | `$pdo->prepare()` | `pool.execute()` |
| **SELECT** | `$stmt->fetchAll()` | `pool.execute()` |

✅ **Resultado:** Funcionalidad idéntica, código equivalente

### **PASO 12: Instalar dependencias**

```bash
npm install              # express, mysql2, dotenv
npm install ejs          # EJS para vistas
```

### **PASO 13: Iniciar servidor**

```bash
npm start
```

**Output:**
```
✅ Conexión a MySQL establecida
🚀 Servidor corriendo en http://localhost:3000
```

---

## 🎯 Características Finales

### ✨ Funcionalidades con Fetch

- ✅ **Sin reload de página** - Experiencia SPA
- ✅ **Guardar contacto** - POST JSON + UI update
- ✅ **Listar contactos** - GET JSON + tabla dinámica
- ✅ **Eliminar contacto** - DELETE JSON + confirmación
- ✅ **Alertas temporales** - Success/error + auto-ocultamiento
- ✅ **Contador dinámico** - Actualiza al guardar/eliminar
- ✅ **Sanitización** - `escapeHtml()` previene XSS

### 🔒 Seguridad

- ✅ Consultas preparadas (SQL injection prevention)
- ✅ Validación server-side
- ✅ HTTP status codes apropiados
- ✅ Error logging en consola
- ✅ Sanitización de salida HTML

---

## 📊 Comparativa de Rutas

### **Formulario Tradicional (Compatibilidad)**
```
POST /guardar → Redirect /listado?success=1
```

### **Fetch/AJAX (Moderno)**
```
POST /api/guardar → JSON { success, mensaje/error }
GET /api/contactos → JSON { success, contactos[] }
DELETE /api/contacto/:id → JSON { success, mensaje/error }
```

---

## 🚀 Pruebas

### **Url disponibles:**
- `http://localhost:3000/` - Formulario
- `http://localhost:3000/listado` - Listado de contactos

### **Flujo de uso:**
1. Abrir formulario (`/`)
2. Llenar campos y enviar
3. Ver mensaje de éxito
4. Tabla se recarga automáticamente
5. Ver nuevo contacto en listado
6. Botón eliminar disponible
7. Confirmación antes de eliminar

---

## 📁 Estructura Final

```
basico-nodejs/
├── .env                      ← Credenciales
├── .gitignore                ← node_modules
├── package.json              ← Dependencias
├── package-lock.json         ← Lock file (npm)
├── conexion.js               ← Pool MySQL
├── index.js                  ← Servidor + rutas
├── PROCESO.md                ← Este archivo
├── README.md                 ← Documentación
├── public/
│   └── js/
│       └── app.js            ← Fetch API
└── views/
    ├── index.ejs             ← Formulario
    ├── listado.ejs           ← Listado
    └── error.ejs             ← Error page
```

---

## ✅ Checklist de Completación

- [x] Crear estructura del proyecto Node.js
- [x] Configurar conexión MySQL
- [x] Crear rutas Express básicas
- [x] Implementar Fetch API
- [x] Crear vistas EJS
- [x] Agregar validaciones
- [x] Implementar CRUD completo (GET, POST, DELETE)
- [x] Sanitización de datos
- [x] Manejo de errores
- [x] Actualizar `.env` con BD correcta
- [x] Instalar dependencias
- [x] Verificar servidor funcionando
- [x] Documentación completa

---

## 🎓 Conceptos Aprendidos

1. **Express.js** - Framework minimalista
2. **mysql2/promise** - Operaciones async a BD
3. **Fetch API** - AJAX moderno con JSON
4. **EJS** - Templates HTML con JS
5. **Middleware Express** - express.urlencoded, express.json, express.static
6. **Consultas preparadas** - Prevención de SQL injection
7. **Pool de conexiones** - Reutilización de conexiones
8. **REST API** - Diseño de rutas HTTP
9. **Error handling** - Try/catch y HTTP codes
10. **SPA (Single Page Application)** - UI sin reload

---

## 📞 Notas Técnicas

- **Pool vs Connection:** Pool reutiliza conexiones, más eficiente
- **JSON vs EJS:** JSON para API, EJS para renderizar vistas
- **Fetch vs XMLHttpRequest:** Fetch es más moderna y limpia
- **Consultas preparadas:** Siempre usar en producción
- **Error logging:** `console.error()` para debugging

---

**Documento generado:** 20 de Abril de 2026
**Última actualización:** Paso 13 - Servidor iniciado ✅
