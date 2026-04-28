# Práctica: Catálogo y Carrito con Clases en PHP

## Objetivo

Convertir una pequeña lógica de tienda en una mini aplicación orientada a objetos (POO) consolidando conceptos clave: **clases, objetos, propiedades, métodos, constructor, `this` y visibilidad**.

## ¿Qué se ha construido?

Una mini aplicación PHP con un catálogo de productos y un carrito de compra funcional que permite:

- ✅ Ver un listado de productos con detalles
- ✅ Añadir productos al carrito desde formularios
- ✅ Guardar el carrito en sesión (persiste entre peticiones)
- ✅ Ver el resumen del carrito con cantidades y total
- ✅ Validar cantidades y stock disponible
- ✅ Calcular IVA (21%)
- ✅ Eliminar productos del carrito
- ✅ Vaciar el carrito completamente
- ✅ Mostrar mensajes claros de error o éxito

---

## Estructura del Proyecto

```
carrito-poo/
├── public/
│   ├── index.php          # Catálogo de productos (página principal)
│   ├── carrito.php        # Vista del carrito
│   └── procesar.php       # Procesador de acciones (controller)
├── src/
│   ├── Producto.php       # Clase Producto
│   ├── Carrito.php        # Clase Carrito
│   └── helpers.php        # Funciones auxiliares y autoloader
├── config/
│   └── (Preparado para evolución futura)
└── README.md              # Este archivo
```

---

## Clases Principales

### 1. Clase `Producto` (src/Producto.php)

Representa un artículo del catálogo.

**Propiedades privadas:**
- `id` (int) - Identificador único
- `nombre` (string) - Nombre del producto
- `precio` (float) - Precio en euros
- `stock` (int) - Unidades disponibles
- `descripcion` (string) - Descripción breve

**Métodos principales:**

```php
// Constructor
public function __construct(int $id, string $nombre, float $precio, int $stock, string $descripcion = '')

// Getters
public function getId(): int
public function getNombre(): string
public function getPrecio(): float
public function getPrecioFormateado(): string  // Devuelve "XX,XX €"
public function getStock(): int

// Validaciones
public function tieneStockSuficiente(int $cantidad): bool

// Manipulación
public function reducirStock(int $cantidad): bool

// Serialización
public function toArray(): array
public static function fromArray(array $datos): self
```

**Concepto de POO aplicado:**
- Encapsulación: Propiedades `private` con getters públicos
- Constructor: Inicializa todos los datos del objeto
- Métodos: Agrupan comportamiento relacionado con el producto

---

### 2. Clase `Carrito` (src/Carrito.php)

Representa el carrito de compra y gestiona los productos añadidos.

**Propiedades privadas:**
- `items` (array) - Array asociativo [id_producto => cantidad]
- `catalogo` (array) - Referencia a los productos disponibles para validar stock

**Métodos principales:**

```php
// Constructor
public function __construct(array $catalogo = [])

// Operaciones principales
public function anadir(int $productoId, int $cantidad): array
public function eliminar(int $productoId): bool
public function reducirCantidad(int $productoId, int $cantidad): array
public function vaciar(): void

// Consultas
public function getNumeroUnidades(): int
public function getNumeroLineas(): int
public function estaVacio(): bool

// Cálculos
public function calcularTotal(): ?float
public function getTotalFormateado(): string
public function calcularIVA(float $porcentaje = 21): ?float
public function calcularTotalConIVA(float $porcentajeIVA = 21): ?float

// Items
public function getItems(): array  // Devuelve items con información completa
public function getItemsRaw(): array
public function setItems(array $items): void

// Sesión
public function setCatalogo(array $catalogo): void
public function getCatalogo(): array
```

**Concepto de POO aplicado:**
- Responsabilidad única: El carrito solo gestiona el carrito
- Validación: Antes de añadir, valida cantidad y stock
- Método `anadir()` devuelve array con resultado y mensaje (patrón Result)
- Métodos de cálculo: Delegan en objetos Producto

---

### 3. Funciones Auxiliares (src/helpers.php)

Funciones globales que no pertenecen a ninguna clase:

```php
// Sesión
iniciarSesion(): void
obtenerCarritoSesion(Carrito $carritoConCatalogo): Carrito
guardarCarritoSesion(Carrito $carrito): void

// Mensajes flash
obtenerMensajeFlash(string $clave = 'mensaje'): ?string
guardarMensajeFlash(string $mensaje, string $clave = 'mensaje'): void

// Validación
sanitizar(string $entrada): string
esNumeroValido($valor): bool

// Datos
crearCatalogo(): array

// Renderizado HTML
renderProducto(Producto $producto): string
renderItemCarrito(array $item): string

// Autoloader
spl_autoload_register() - Carga automática de clases
```

---

## Flujo de la Aplicación

### 1. **Cargar la página inicial (index.php)**

```
→ Iniciar sesión
→ Crear catálogo (array de objetos Producto)
→ Obtener carrito de sesión (o crear uno nuevo)
→ Mostrar todos los productos en HTML
→ Mostrar botón flotante con contador de artículos
```

### 2. **Añadir producto al carrito**

```
→ Usuario rellena cantidad y hace submit
→ procesar.php recibe el POST
→ Valida ID y cantidad
→ Llama a $carrito->anadir($id, $cantidad)
→ Carrito valida: cantidad > 0, producto existe, stock disponible
→ Si OK: añade/suma cantidad a items
→ Guarda carrito en $_SESSION['carrito']
→ Redirige a index.php con mensaje flash
```

### 3. **Ver carrito (carrito.php)**

```
→ Obtener carrito de sesión
→ Mostrar tabla con todos los items
→ Calcular totales: subtotal, IVA, total
→ Mostrar botones: eliminar, vaciar, seguir comprando
```

### 4. **Eliminar producto**

```
→ Usuario hace click en botón eliminar
→ procesar.php recibe POST con acción='eliminar'
→ Llama a $carrito->eliminar($id)
→ Guarda carrito en sesión
→ Redirige a carrito.php con mensaje de confirmación
```

---

## Validaciones Implementadas

### En la clase Carrito

1. **Cantidad válida**: Debe ser > 0
2. **Producto existe**: Debe encontrarse en el catálogo
3. **Stock suficiente**: No puede exceder el stock disponible
4. **Suma de cantidades**: Si el producto ya está en el carrito, valida que la nueva suma no supere el stock

### En procesar.php

1. Valida que los datos POST sean números válidos
2. Sanitiza entradas
3. Maneja excepciones y devuelve mensajes de error claros

---

## Persistencia en Sesión

El carrito **se guarda en `$_SESSION['carrito']`** como un array simple:

```php
$_SESSION['carrito'] = [
    1 => 2,    // 2 unidades del producto 1
    3 => 1,    // 1 unidad del producto 3
    5 => 3     // 3 unidades del producto 5
]
```

Al cargar cualquier página, se recupera este array y se reestablece en el objeto Carrito:

```php
$carrito = new Carrito($catalogo);
$carrito->setItems($_SESSION['carrito']);
```

De esta forma, **el carrito persiste entre peticiones** pero la lógica está encapsulada en la clase.

---

## Concepto de POO Utilizado

### ✅ Encapsulación

Todas las propiedades son `private`. Solo se accede a ellas a través de métodos públicos:

```php
// ❌ No se puede hacer esto
$producto->precio = 100;

// ✅ Se hace así (si existe getter/setter)
$precio = $producto->getPrecio();
```

### ✅ Constructor

Inicializa el objeto con sus datos desde el principio:

```php
$producto = new Producto(1, 'Laptop', 899.99, 5, 'Descripción');
```

### ✅ `this`

Se utiliza dentro de métodos para acceder a propiedades de la instancia:

```php
public function tieneStockSuficiente(int $cantidad): bool
{
    return $cantidad > 0 && $cantidad <= $this->stock;
}
```

### ✅ Métodos

Agrupan comportamiento relacionado:
- Cálculos: `calcularTotal()`, `calcularIVA()`
- Validaciones: `tieneStockSuficiente()`
- Operaciones: `anadir()`, `eliminar()`

### ✅ Responsabilidad Única

- `Producto`: Representa un producto y sus datos
- `Carrito`: Gestiona el carrito y sus operaciones
- `helpers.php`: Funciones de utilidad y sesión
- `procesar.php`: Controlador que maneja peticiones
- Vistas (`index.php`, `carrito.php`): Renderizado HTML

---

## Cómo Usar la Aplicación

### 1. **Acceder a la tienda**

```
http://localhost/carrito-poo/public/index.php
```

### 2. **Añadir un producto**

- Selecciona la cantidad (validación mínima: 1)
- Haz click en "Añadir"
- Se valida stock y cantidad
- Se muestra mensaje de éxito o error

### 3. **Ver carrito**

- Click en el botón "Carrito" de la navbar
- O click en el botón flotante con el contador

### 4. **Modificar carrito**

- Ver tabla con todos los productos
- Click en la papelera para eliminar un producto
- Click en "Vaciar carrito" para vaciar todo

---

## Mejoras Realizadas (Opcionales)

### ✅ Implementadas

1. ✅ Cálculo de IVA (21%)
2. ✅ Vaciar carrito completo
3. ✅ Eliminar líneas individuales
4. ✅ Mensajes flash en sesión
5. ✅ Contador de artículos en botón flotante
6. ✅ Validación visual de stock (botones deshabilitados si no hay stock)
7. ✅ Interfaz moderna con Bootstrap 5

### 📋 Ideas para futuras evoluciones

1. **ProductoRepository**: Clase para abstraer la carga de productos (en lugar de array)
2. **SessionCartStorage**: Clase para encapsular la lógica de sesión del carrito
3. **Descuentos**: Aplicar porcentajes de descuento automáticos
4. **Cupones**: Códigos de promoción
5. **Historial**: Guardar historial de carritos anteriores
6. **Base de datos**: Leer productos desde MySQL con PDO

---

## Diseño para Evolución: Herencia y Polimorfismo

### Problema: Productos físicos vs digitales

Cuando la tienda tenga ambos tipos, notaremos que se comportan distinto:

```php
class ProductoFisico extends Producto {
    private float $peso;
    private float $dimensiones;
    
    public function calcularEnvio(): float {
        return 5.99; // Costo base
    }
}

class ProductoDigital extends Producto {
    private string $urlDescarga;
    
    public function calcularEnvio(): float {
        return 0; // Sin envío
    }
}
```

De esta forma, el carrito seguiría funcionando igual, pero cada tipo de producto se comportaría diferente.

---

## Ejecución Paso a Paso

### Paso 1: Crear estructura

```bash
mkdir -p carrito-poo/public carrito-poo/src carrito-poo/config
```

### Paso 2: Crear clases

```php
// src/Producto.php - Propiedades y métodos
// src/Carrito.php - Gestión del carrito
// src/helpers.php - Funciones auxiliares
```

### Paso 3: Crear vistas

```php
// public/index.php - Catálogo
// public/carrito.php - Resumen
// public/procesar.php - Controlador
```

### Paso 4: Probar

```
1. Ir a http://localhost/carrito-poo/public/index.php
2. Añadir productos
3. Ver carrito
4. Modificar carrito
5. Verificar que la sesión persista (recargar página)
```

---

## Conceptos Clave Aprendidos

| Concepto | Implementado | Dónde |
|----------|-------------|--------|
| **Clases** | Producto, Carrito | `src/` |
| **Objetos** | `new Producto()`, `new Carrito()` | Toda la app |
| **Propiedades** | `private` en ambas clases | Encapsuladas |
| **Métodos** | Getters, setters, acciones | En cada clase |
| **Constructor** | `__construct()` | Producto, Carrito |
| **`this`** | Acceso a propiedades | Dentro de métodos |
| **Visibilidad** | `private`, `public` | Encapsulación |
| **Sesión** | Persistencia del carrito | `$_SESSION` |
| **Arrays** | Items, catálogo | Datos |
| **Validación** | Stock, cantidades | Carrito |
| **POO vs Procedural** | Orden > Caos | Comparación |

---

## Notas de Desarrollo

### ✅ Lo que funciona bien

- La separación de responsabilidades es clara
- El carrito es reutilizable y testeable
- Las clases pueden evolucionar sin afectar a otras
- La sesión se abstrae detrás de helpers
- Las vistas están limpias de lógica

### 📝 Para mejorar

- Añadir validación más exhaustiva (inyección de dependencias)
- Usar una base de datos real en lugar de arrays
- Implementar eventos/observers para cambios en carrito
- Añadir logging de acciones
- Tests unitarios para Producto y Carrito

---

## Resumen

Esta práctica consolida los conceptos de POO mediante una aplicación **real y funcional**. 

No es POO "porque sí", sino porque el código queda:

✅ **Más claro**: Las clases representan conceptos reales (Producto, Carrito)  
✅ **Más reutilizable**: Cada clase puede usarse en otros contextos  
✅ **Más mantenible**: Los cambios se localizan en un lugar  
✅ **Más escalable**: Preparado para evolucionar con herencia y polimorfismo  

---

## Autor

Práctica de POO en PHP - Curso Backend Light 2026

**Estado**: ✅ Funcional y documentado

**Última actualización**: 28/04/2026
