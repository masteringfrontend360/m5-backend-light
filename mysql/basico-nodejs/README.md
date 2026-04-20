# Práctica · Base de datos con Node.js, Express y MySQL

## Objetivo

Crear la misma aplicación de contactos pero con **JavaScript (Node.js)** en lugar de PHP.

## Stack

- **Backend:** Node.js + Express
- **Frontend:** HTML + CSS + JavaScript (Fetch API + EJS)
- **Base de datos:** MySQL
- **Gestor de dependencias:** npm

## Estructura

```
basico-nodejs/
├── .env              ← Credenciales de BD
├── conexion.js       ← Pool de conexiones MySQL
├── index.js          ← Servidor Express + rutas
├── package.json      ← Dependencias
├── public/
│   └── js/
│       └── app.js    ← Fetch API para AJAX
├── views/
│   ├── index.ejs     ← Formulario con fetch
│   ├── listado.ejs   ← Listado dinámico con fetch
│   └── error.ejs     ← Página de error
└── README.md
```

## Instalación

```bash
# 1. Instalar dependencias
npm install

# 2. Configurar .env con tus credenciales de MySQL
# 3. Crear la BD y tabla (ver más abajo)
# 4. Ejecutar el servidor
npm start
```

## Crear la BD y tabla

```sql
-- Crear base de datos
CREATE DATABASE curso_mysql CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE curso_mysql;

-- Crear tabla
CREATE TABLE contactos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    ciudad VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Rutas

### Frontend (EJS)
- **GET `/`** → Formulario para añadir contacto (con fetch)
- **GET `/listado`** → Mostrar todos los contactos (con fetch)

### Backend API (JSON)
- **POST `/api/guardar`** → Guardar contacto (fetch/AJAX)
- **GET `/api/contactos`** → Obtener todos los contactos (JSON)
- **DELETE `/api/contacto/:id`** → Eliminar contacto (fetch/AJAX)

### Compatibilidad
- **POST `/guardar`** → Guardar contacto (formulario tradicional - redirect)

## Características con Fetch

✨ **Sin reload de página**
- Guardar contacto → Mensaje + Recarga de tabla
- Eliminar contacto → Mensaje + Recarga de tabla

✨ **Feedback en tiempo real**
- Alertas de éxito/error
- Auto-ocultamiento después de 3 segundos
- Actualización dinámica del contador

✨ **Seguridad**
- Sanitización de datos con `escapeHtml()`
- Validación en servidor
- Consultas preparadas

## Validaciones

✅ Campos obligatorios (nombre, email)
✅ Longitud máxima de campos
✅ Validación de email
✅ Consultas preparadas (previene SQL injection)
✅ Manejo de errores con try/catch
✅ Errores con HTTP status codes correctos

## Ejecución

```bash
# Modo normal
npm start

# Modo desarrollo (con auto-reload)
npm run dev
```

El servidor estará disponible en `http://localhost:3000`

## Cómo funciona Fetch

### Guardar contacto
```javascript
const response = await fetch('/api/guardar', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nombre, email, ciudad })
});
const datos = await response.json();
```

### Cargar contactos
```javascript
const response = await fetch('/api/contactos');
const datos = await response.json();
// datos.contactos contiene el array
```

### Eliminar contacto
```javascript
const response = await fetch(`/api/contacto/${id}`, {
    method: 'DELETE'
});
const datos = await response.json();
```

