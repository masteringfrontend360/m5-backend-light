<?php

/**
 * GUÍA RÁPIDA DE INICIO
 * 
 * Este archivo contiene instrucciones para ejecutar y entender la aplicación
 */

?>

# Guía Rápida de Inicio - Carrito POO

## 🚀 Cómo ejecutar la aplicación

### Opción 1: Con servidor web (recomendado)

```bash
# Ir a la carpeta del proyecto
cd /var/www/html/carrito-poo

# Si tienes LAMP ejecutándose:
# Abre en el navegador: http://localhost/carrito-poo/public/index.php
```

### Opción 2: Pruebas sin servidor

```bash
# Ejecutar las pruebas unitarias
php test.php
```

---

## 📁 Estructura de archivos

```
carrito-poo/
├── src/
│   ├── Producto.php      # Clase que representa un producto
│   ├── Carrito.php       # Clase que gestiona el carrito
│   └── helpers.php       # Funciones auxiliares y autoloader
├── public/
│   ├── index.php         # Página principal (catálogo)
│   ├── carrito.php       # Página del carrito
│   └── procesar.php      # Controlador de acciones
├── test.php              # Script de pruebas
└── README.md             # Documentación completa
```

---

## 🎯 Funcionalidades principales

### ✅ Mostrar productos
- Accede a `http://localhost/carrito-poo/public/index.php`
- Verás 6 productos de ejemplo
- Cada producto muestra: nombre, descripción, precio y stock disponible

### ✅ Añadir al carrito
- Selecciona la cantidad que deseas
- Haz click en "Añadir"
- Se valida que:
  - La cantidad sea válida (> 0)
  - Haya stock suficiente
  - No superes lo disponible
- Verás un mensaje de confirmación o error

### ✅ Ver carrito
- Click en el botón "Carrito" de la navbar
- O click en el botón flotante con el contador rojo
- Se muestra:
  - Lista de productos con cantidad y subtotal
  - Número de unidades
  - Subtotal
  - IVA (21%)
  - Total

### ✅ Modificar carrito
- Click en la papelera para eliminar un producto
- Click en "Vaciar carrito" para eliminar todo
- Los cambios se guardan automáticamente en sesión

---

## 💡 Conceptos de POO aplicados

### 1. **Encapsulación**
Las propiedades de las clases son `private`. Solo se accede a través de métodos públicos.

```php
// ❌ Esto NO funciona:
$producto->precio = 100;

// ✅ Esto SÍ funciona:
$precio = $producto->getPrecio();
```

### 2. **Constructor**
Inicializa todos los datos del objeto desde el principio.

```php
$producto = new Producto(
    1,                          // id
    'Laptop',                   // nombre
    899.99,                     // precio
    5,                          // stock
    'Laptop de alta performance' // descripción
);
```

### 3. **`this`**
Se usa dentro de métodos para acceder a propiedades de la instancia.

```php
public function tieneStockSuficiente(int $cantidad): bool
{
    return $cantidad > 0 && $cantidad <= $this->stock;
    //                                     ^^^^^^^^^^
    //                                     Propiedad del objeto actual
}
```

### 4. **Responsabilidad Única**
- `Producto` solo representa datos de un producto
- `Carrito` solo gestiona el carrito
- Las vistas solo muestran información
- `procesar.php` maneja las peticiones

---

## 🔍 Flujo paso a paso

### Cuando añades un producto:

1. **Rellenas el formulario** (index.php)
   - ID producto: 1
   - Cantidad: 2
   - Haces click en "Añadir"

2. **Se envía POST a procesar.php**
   ```php
   POST /procesar.php
   - accion=anadir
   - producto_id=1
   - cantidad=2
   ```

3. **procesar.php procesa la acción**
   - Crea/recupera el carrito
   - Llama a `$carrito->anadir(1, 2)`

4. **Carrito valida y añade**
   ```php
   // En Carrito::anadir()
   - ¿cantidad > 0? ✅
   - ¿producto existe? ✅
   - ¿stock disponible? ✅
   - Añade: $this->items[1] = 2
   ```

5. **Guarda carrito en sesión**
   ```php
   $_SESSION['carrito'] = [1 => 2];
   ```

6. **Redirige a index.php**
   - Muestra mensaje de éxito
   - Actualiza el contador de artículos

---

## 🧪 Ejecutar pruebas

```bash
cd /var/www/html/carrito-poo
php test.php
```

Verás todas las pruebas ejecutarse:
- Crear productos ✅
- Acceder a propiedades ✅
- Validar stock ✅
- Añadir productos ✅
- Calcular totales ✅
- Eliminar productos ✅
- Vaciar carrito ✅
- Validaciones ✅

---

## 📊 Datos de ejemplo

Se incluyen 6 productos de ejemplo:

```
1. Laptop Dell              - 899,99 € (5 unidades)
2. Ratón Logitech          - 29,99 € (15 unidades)
3. Teclado Mecánico        - 149,99 € (8 unidades)
4. Monitor LG 4K           - 399,99 € (3 unidades)
5. Webcam HD               - 79,99 € (12 unidades)
6. Hub USB-C               - 49,99 € (20 unidades)
```

---

## 🔧 Personalizar el catálogo

### Opción 1: Modificar el array en helpers.php

Abre `src/helpers.php` y edita la función `crearCatalogo()`:

```php
function crearCatalogo(): array
{
    return [
        new Producto(1, 'Tu Producto', 99.99, 10, 'Descripción'),
        // Añade más productos aquí
    ];
}
```

### Opción 2: Cargar desde base de datos (evolución futura)

Crea una clase `ProductoRepository` que lea de MySQL:

```php
class ProductoRepository {
    public function obtenerTodos(): array {
        // Leer de base de datos
        // Devolver array de Productos
    }
}
```

---

## 🐛 Solucionar problemas

### "No se muestra el catálogo"
- Verifica que Apache está ejecutándose
- Comprueba que las carpetas existen
- Revisa permisos: `chmod 755 public/`

### "El carrito no persiste al recargar"
- Verifica que sesiones están habilitadas en PHP
- Comprueba `php.ini`: `session.save_path` debe ser escribible

### "Error de autoloader"
- Asegúrate de que `src/helpers.php` se requiere correctamente
- Verifica que el namespace es `CarritoPOO`

### "Error de visibilidad (propiedades privadas)"
- No puedes acceder a `$producto->precio`
- Usa `$producto->getPrecio()`

---

## 📚 Recursos adicionales

- **README.md**: Documentación completa y detallada
- **test.php**: Código de ejemplo de cómo usar las clases
- **Código comentado**: Todas las clases tienen comentarios explicativos

---

## 🚀 Próximos pasos (Evoluciones)

1. **Base de datos**: Leer productos desde MySQL
2. **Usuarios**: Sistema de login y historial de compras
3. **Búsqueda**: Filtrar productos por categoría o precio
4. **Cupones**: Aplicar códigos de descuento
5. **Pago**: Integrar un sistema de pagos (Stripe, PayPal)
6. **Herencia**: Tipos de productos distintos (físico, digital)
7. **Tests**: Tests unitarios con PHPUnit
8. **API REST**: Hacer peticiones AJAX sin recargar página

---

## 💾 Guardar tu trabajo

```bash
# Si usas Git
cd /var/www/html/carrito-poo
git add .
git commit -m "Práctica: Catálogo y carrito POO"
git push
```

---

**Última actualización**: 28/04/2026  
**Estado**: ✅ Funcional y probado
