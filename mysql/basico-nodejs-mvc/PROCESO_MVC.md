# 📋 Proceso de Creación - Proyecto basico-nodejs-mvc (MVC)

## 📅 Fecha: 28 de Abril de 2026

---

## 🎯 Objetivo
Crear un segundo proyecto **idéntico en funcionalidad** al anterior pero implementando el **patrón MVC** (Model-View-Controller).

---

## 📊 Comparativa: Original vs MVC

| Aspecto | basico-nodejs | basico-nodejs-mvc |
|---------|---------------|-------------------|
| **Estructura** | Todo en `index.js` | Separado en carpetas |
| **Escalabilidad** | Media | Alta |
| **Mantenibilidad** | Difícil | Fácil |
| **Testing** | Complicado | Simple |
| **Profesionalismo** | Básico | Avanzado |

---

## 🏗️ Estructura MVC Creada

```
basico-nodejs-mvc/
├── config/
│   └── database.js              ← Conexión (reutilizable)
├── models/
│   └── ContactoModel.js         ← Queries a BD
├── controllers/
│   └── ContactoController.js    ← Lógica HTTP
├── routes/
│   └── contactoRoutes.js        ← Mapeo URLs
├── utils/
│   └── validaciones.js          ← Funciones compartidas
├── views/
│   ├── index.ejs
│   ├── listado.ejs
│   └── error.ejs
├── public/js/
│   └── app.js                   ← Fetch API
├── index.js                     ← Punto de entrada limpio
├── package.json
├── .env
└── README.md
```

---

## 📝 Paso a Paso de Implementación

### **PASO 1: Crear estructura de directorios**

```bash
mkdir -p config models controllers routes utils views public/js
```

**Carpetas creadas:**
- `config/` - Configuración (BD, email, etc)
- `models/` - Modelos (clase de datos)
- `controllers/` - Controladores (lógica HTTP)
- `routes/` - Rutas (mapeo URLs)
- `utils/` - Funciones reutilizables
- `views/` - Vistas EJS
- `public/` - Assets estáticos

### **PASO 2: Crear archivos base**

**`package.json`** - Igual al anterior
**`.env`** - Igual al anterior

### **PASO 3: Crear capa de Configuración**

**Archivo: `config/database.js`**

```javascript
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

export const pool = mysql.createPool(config);

try {
    const connection = await pool.getConnection();
    console.log('✅ Conexión a MySQL establecida');
    connection.release();
}
```

**Responsabilidad:**
- Centralizar configuración de BD
- Reutilizable en toda la app
- Verificación automática al iniciar

### **PASO 4: Crear capa de Modelo**

**Archivo: `models/ContactoModel.js`**

Clase con métodos estáticos para BD:

```javascript
class ContactoModel {
    static async obtenerTodos() { ... }
    static async obtenerPorId(id) { ... }
    static async crear(nombre, email, ciudad) { ... }
    static async actualizar(id, ...) { ... }
    static async eliminar(id) { ... }
}
```

**Beneficios:**
- Separar lógica de BD del controller
- Reutilizar queries
- Fácil de testear
- Cambios en BD aquí

### **PASO 5: Crear capa de Utilidades**

**Archivo: `utils/validaciones.js`**

```javascript
export const validarContacto = (nombre, email, ciudad) => {
    // Validación centralizada
    // Reutilizable en Controller
}
```

**Beneficio:**
- No duplicar validación
- Cambios en un lugar
- Reutilizable entre rutas

### **PASO 6: Crear capa de Controlador**

**Archivo: `controllers/ContactoController.js`**

Clase con métodos estáticos por ruta:

```javascript
class ContactoController {
    // GET - Mostrar formulario
    static async mostrarFormulario(req, res) { ... }
    
    // GET - Mostrar listado
    static async mostrarListado(req, res) { ... }
    
    // POST - Guardar (formulario)
    static async guardarTradicional(req, res) { ... }
    
    // POST - Guardar (JSON/Fetch)
    static async guardarAjax(req, res) { ... }
    
    // GET - Obtener todos (JSON)
    static async obtenerTodos(req, res) { ... }
    
    // DELETE - Eliminar
    static async eliminar(req, res) { ... }
}
```

**Flujo típico:**
```javascript
static async guardarAjax(req, res) {
    // 1. Obtener datos
    const { nombre, email, ciudad } = req.body;
    
    // 2. Validar (Utils)
    const validacion = validarContacto(...);
    if (!validacion.valido) return res.status(400).json(...);
    
    // 3. Procesar (Model)
    try {
        await ContactoModel.crear(...);
        res.json({ success: true });
    } catch (err) {
        res.status(500).json({ success: false });
    }
}
```

**Responsabilidad:**
- Recibir request
- Delegar al Model
- Retornar response
- NO lógica de BD

### **PASO 7: Crear capa de Rutas**

**Archivo: `routes/contactoRoutes.js`**

```javascript
import express from 'express';
import ContactoController from '../controllers/ContactoController.js';

const router = express.Router();

router.get('/', ContactoController.mostrarFormulario);
router.post('/guardar', ContactoController.guardarTradicional);
router.post('/api/guardar', ContactoController.guardarAjax);
router.get('/api/contactos', ContactoController.obtenerTodos);
router.delete('/api/contacto/:id', ContactoController.eliminar);

export default router;
```

**Beneficio:**
- Todas las rutas en un lugar
- Fácil de ver qué está disponible
- Separar rutas en múltiples archivos si crece

### **PASO 8: Simplificar index.js**

**Archivo: `index.js`**

```javascript
import express from 'express';
import './config/database.js';
import contactoRoutes from './routes/contactoRoutes.js';

const app = express();

// Middleware
app.use(express.urlencoded({ extended: false }));
app.use(express.json());
app.use(express.static('public'));
app.set('view engine', 'ejs');

// Rutas
app.use('/', contactoRoutes);

// Error 404
app.use((req, res) => {
    res.status(404).render('error', {
        mensaje: 'Página no encontrada'
    });
});

// Iniciar
app.listen(PORT, () => {
    console.log(`🚀 Servidor MVC corriendo en http://localhost:${PORT}`);
});
```

**Cambios vs anterior:**
- Sin lógica de validación
- Sin consultas a BD
- Solo middleware, rutas e inicialización
- Mucho más limpio y legible

### **PASO 9: Crear Vistas (igual que antes)**

**`views/index.ejs`** - Formulario
**`views/listado.ejs`** - Listado
**`views/error.ejs`** - Error

### **PASO 10: Crear Frontend (igual que antes)**

**`public/js/app.js`** - Fetch API

## 🔄 Flujo de Datos MVC

### **Ejemplo 1: Guardar contacto (Fetch)**

```
1. Usuario llena formulario y envía (click submit)
   ↓
2. app.js intercepta: guardarContactoFetch()
   ↓
3. Fetch POST a /api/guardar (JSON)
   ↓
4. Express: GET /api/guardar → contactoRoutes
   ↓
5. Ruta mapea a: ContactoController.guardarAjax()
   ↓
6. Controlador:
   - Obtiene datos de req.body
   - Llama: validarContacto() (Utils)
   - Llama: ContactoModel.crear() (Model)
   ↓
7. Modelo:
   - Ejecuta: pool.execute(sql)
   ↓
8. Respuesta JSON: { success: true }
   ↓
9. app.js recibe respuesta
   ↓
10. Actualiza UI dinámicamente
```

### **Ejemplo 2: Listar contactos**

```
1. Usuario accede a /listado
   ↓
2. Express: GET /listado → contactoRoutes
   ↓
3. Ruta mapea a: ContactoController.mostrarListado()
   ↓
4. Controlador:
   - Llama: ContactoModel.obtenerTodos()
   ↓
5. Modelo:
   - Ejecuta: SELECT query
   ↓
6. Controlador renderiza:
   res.render('listado', { contactos })
   ↓
7. EJS interpola datos y renderiza HTML
   ↓
8. Página carga con datos en tabla
   ↓
9. JavaScript carga:
   - Agrega listener a botones
   - Fetch GET /api/contactos (recarga dinámica)
```

## 🎯 Patrones Aprendidos

### **1. Model Pattern**
- Clase estática con métodos de BD
- Encapsula SQL
- Reutilizable

### **2. Controller Pattern**
- Métodos por ruta
- Orquesta Model y Utils
- Maneja solicitudes HTTP

### **3. Route Pattern**
- Mapeo centralizado
- Fácil de encontrar endpoints

### **4. Utils Pattern**
- Funciones compartidas
- Sin duplicación
- Fácil de cambiar

## ✨ Ventajas del MVC

| Ventaja | Detalle |
|---------|---------|
| **Separación** | Cada cosa en su lugar |
| **Reutilización** | Model usado en múltiples controllers |
| **Testing** | Fácil testear Model sin HTTP |
| **Mantenimiento** | Cambios localizados |
| **Escalabilidad** | Fácil agregar funcionalidad |
| **Profesional** | Patrón usado en industria |
| **Documentación** | Estructura es auto-documentada |

## 📈 Crecimiento Futuro

**De MVC a proyecto empresarial:**

```
basico-nodejs-mvc/           ← Aprendizaje
    ↓ (agregar)
+ Middleware de autenticación ← JWT/Sessions
+ Modelos relacionales        ← Herencias, validaciones
+ Service layer               ← Lógica compartida
+ Request/Response DTOs       ← Validación de schema
+ Logging centralizado        ← Winston/Pino
+ Error handling global       ← Express middleware
+ CORS y seguridad            ← Helmet
+ Rate limiting               ← Express-ratelimit
    ↓ (resultado)
Aplicación empresarial ✅
```

## 🔍 Diferencia Clave

**Versión procedural (basico-nodejs):**
```
Request → index.js → Validar → Queries → Response
         (400 líneas)
```

**Versión MVC (basico-nodejs-mvc):**
```
Request → Routes → Controller → Model → Response
         (cada archivo ~50 lineas)
```

## 🚀 Para ejecutar

```bash
npm install
npm start
```

**Resultado:**
```
✅ Conexión a MySQL establecida
🚀 Servidor MVC corriendo en http://localhost:3000
```

---

## 📚 Referencias MVC

- **Model:** Datos y lógica
- **View:** Presentación
- **Controller:** Orquestación

```
       HTTP Request
            ↓
        ┌─────────┐
        │ Router  │
        └────┬────┘
             ↓
       ┌──────────────┐
       │ Controller   │
       └──┬───────┬───┘
          ↓       ↓
       ┌─────┐ ┌──────┐
       │Model│ │Utils │
       └──┬──┘ └──────┘
          ↓
       ┌─────┐
       │ BD  │
       └─────┘
```

---

**Documento generado:** 28 de Abril de 2026
**Patrón:** Model-View-Controller (MVC)
**Objetivo:** Profesionalización de código ✅
