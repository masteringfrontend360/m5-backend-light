# 🏗️ Contactos App - MVC (Model-View-Controller)

## Objetivo

Replicar el proyecto de contactos usando el **patrón MVC** para una arquitectura más profesional y mantenible.

## Stack

- **Backend:** Node.js + Express
- **Frontend:** HTML + CSS + JavaScript (Fetch API)
- **Patrón:** MVC (Model-View-Controller)
- **Base de datos:** MySQL
- **Template Engine:** EJS

## Estructura MVC

```
basico-nodejs-mvc/
├── config/
│   └── database.js         ← Conexión a MySQL (configuración)
├── models/
│   └── ContactoModel.js    ← Métodos de BD (Model)
├── controllers/
│   └── ContactoController.js ← Lógica de negocios (Controller)
├── routes/
│   └── contactoRoutes.js   ← Definición de rutas
├── utils/
│   └── validaciones.js     ← Funciones reutilizables
├── views/
│   ├── index.ejs           ← Formulario (View)
│   ├── listado.ejs         ← Listado (View)
│   └── error.ejs           ← Error (View)
├── public/
│   └── js/
│       └── app.js          ← Fetch API (Frontend)
├── index.js                ← Entrada principal
├── package.json
├── .env
└── README.md
```

## Patrones y Conceptos

### 📦 Model (Modelo)
- **Archivo:** `models/ContactoModel.js`
- **Responsabilidad:** Operaciones directas a BD
- **Métodos estáticos:**
  - `obtenerTodos()` - SELECT all
  - `obtenerPorId(id)` - SELECT by ID
  - `crear(nombre, email, ciudad)` - INSERT
  - `actualizar(id, nombre, email, ciudad)` - UPDATE
  - `eliminar(id)` - DELETE

```javascript
// Uso
const contactos = await ContactoModel.obtenerTodos();
await ContactoModel.crear(nombre, email, ciudad);
```

### 🎮 Controller (Controlador)
- **Archivo:** `controllers/ContactoController.js`
- **Responsabilidad:** Lógica de negocios y solicitudes HTTP
- **Métodos estáticos:**
  - `mostrarFormulario(req, res)` - Renderizar formulario
  - `mostrarListado(req, res)` - Renderizar listado
  - `guardarTradicional(req, res)` - POST formulario
  - `guardarAjax(req, res)` - POST JSON
  - `obtenerTodos(req, res)` - GET JSON
  - `eliminar(req, res)` - DELETE JSON

```javascript
// Flujo: Request → Controller → Model → Response
static async guardarAjax(req, res) {
    const validacion = validarContacto(...);
    if (!validacion.valido) return res.status(400).json(...);
    
    await ContactoModel.crear(...); // Delegar al modelo
    res.json({ success: true });
}
```

### 🎨 View (Vista)
- **Archivos:** `views/*.ejs`
- **Responsabilidad:** Presentación de datos
- **Vistas:**
  - `index.ejs` - Formulario (GET `/`)
  - `listado.ejs` - Listado (GET `/listado`)
  - `error.ejs` - Errores (cualquier error)

### 📍 Routes (Rutas)
- **Archivo:** `routes/contactoRoutes.js`
- **Responsabilidad:** Mapear URLs a Controllers
- **Beneficio:** Centralizar definición de rutas

```javascript
router.post('/api/guardar', ContactoController.guardarAjax);
```

### 🔧 Utils (Utilidades)
- **Archivo:** `utils/validaciones.js`
- **Responsabilidad:** Funciones reutilizables compartidas

```javascript
export const validarContacto = (nombre, email, ciudad) => { ... }
```

## Flujo de Datos MVC

### **Guardar contacto (Fetch)**
```
View (formulario)
    ↓ (fetch POST)
    Controller.guardarAjax()
    ↓
    Utils.validarContacto()
    ↓
    Model.crear()
    ↓
    Response JSON
    ↓
    View (actualiza dinámicamente)
```

### **Listar contactos**
```
View (página listado)
    ↓ (página carga)
    Controller.mostrarListado()
    ↓
    Model.obtenerTodos()
    ↓
    Renderiza EJS
    ↓
    JavaScript: fetch /api/contactos
    ↓
    Controller.obtenerTodos()
    ↓
    Response JSON
    ↓
    View (tabla dinámica)
```

## Ventajas del Patrón MVC

✅ **Separación de responsabilidades**
- Modelo: BD
- Controlador: Lógica
- Vista: Presentación

✅ **Reutilización de código**
- Métodos en Model
- Funciones en Utils
- Controllers llamados desde múltiples rutas

✅ **Fácil de mantener**
- Cambios en BD: editar Model
- Cambios en lógica: editar Controller
- Cambios en diseño: editar View

✅ **Escalable**
- Agregar nuevas rutas es simple
- Agregar nuevos modelos es simple
- Testing más fácil

✅ **Profesional**
- Estructura reconocida en industria
- Facilita trabajo en equipo
- Estándar en Laravel, Django, etc.

## Instalación

```bash
npm install
npm install ejs
npm start
```

## Rutas Disponibles

| Método | URL | Tipo | Controlador |
|--------|-----|------|-------------|
| GET | `/` | HTML | mostrarFormulario |
| GET | `/listado` | HTML | mostrarListado |
| POST | `/guardar` | Form | guardarTradicional |
| POST | `/api/guardar` | JSON | guardarAjax |
| GET | `/api/contactos` | JSON | obtenerTodos |
| DELETE | `/api/contacto/:id` | JSON | eliminar |

## Comparativa: Original vs MVC

### Original (basico-nodejs)
```
index.js
├── Middleware
├── Validación
├── Rutas
├── Lógica de BD
└── Error handling
```
**Problema:** Todo mezclado en 1 archivo

### MVC (basico-nodejs-mvc)
```
index.js (solo middleware y rutas)
├── routes/ (mapeo)
├── controllers/ (lógica)
├── models/ (BD)
├── views/ (presentación)
└── utils/ (reutilizable)
```
**Ventaja:** Cada cosa en su lugar

## Testing

Si agregaras tests (Jest), sería muy fácil:

```javascript
// test/ContactoModel.test.js
describe('ContactoModel', () => {
    test('obtenerTodos devuelve array', async () => {
        const contactos = await ContactoModel.obtenerTodos();
        expect(Array.isArray(contactos)).toBe(true);
    });
});
```

## Próximos pasos para mejorar

- [ ] Agregar autenticación (JWT)
- [ ] Agregar validación de permisos (middleware)
- [ ] Usar BD con relaciones
- [ ] Agregar caché (Redis)
- [ ] Agregar tests unitarios
- [ ] Dockerizar la aplicación
- [ ] Agregar logging más detallado

---

**Patrón:** MVC  
**Desde:** basico-nodejs (procedural)  
**A:** basico-nodejs-mvc (orientado a estructura)
