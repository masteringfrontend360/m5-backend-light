<?php

/**
 * EJEMPLOS DE USO DE LAS CLASES
 * 
 * Este archivo muestra cómo usar las clases Producto y Carrito
 * en diferentes contextos
 */

?>

# Ejemplos de Uso - Carrito POO

## 1. Crear un Producto

### Básico

```php
<?php
require_once 'src/helpers.php';

use CarritoPOO\Producto;

// Crear un producto
$laptop = new Producto(
    1,                              // ID
    'Laptop Dell',                  // Nombre
    899.99,                         // Precio
    5,                              // Stock
    'Laptop de alta performance'   // Descripción
);

echo $laptop->getNombre();              // "Laptop Dell"
echo $laptop->getPrecioFormateado();    // "899,99 €"
echo $laptop->getStock();               // 5
?>
```

### Validar Stock

```php
<?php
// ¿Hay 3 unidades disponibles?
if ($laptop->tieneStockSuficiente(3)) {
    echo "Hay stock suficiente";
} else {
    echo "No hay stock";
}

// ¿Hay 10 unidades? (solo hay 5)
if ($laptop->tieneStockSuficiente(10)) {
    echo "Hay stock";
} else {
    echo "No hay stock"; // Esto se imprime
}
?>
```

---

## 2. Crear un Carrito

### Vacío

```php
<?php
use CarritoPOO\Carrito;

$carrito = new Carrito();
echo $carrito->estaVacio() ? "Vacío" : "Con items";  // "Vacío"
?>
```

### Con catálogo

```php
<?php
$catalogo = [
    new Producto(1, 'Laptop', 899.99, 5),
    new Producto(2, 'Ratón', 29.99, 20),
];

$carrito = new Carrito($catalogo);
?>
```

---

## 3. Añadir Productos al Carrito

### Ejemplo exitoso

```php
<?php
$resultado = $carrito->anadir(1, 2);

if ($resultado['exito']) {
    echo "✅ " . $resultado['mensaje'];
    // ✅ Producto añadido: 2 unidades de Laptop
} else {
    echo "❌ " . $resultado['mensaje'];
}
?>
```

### Validaciones

```php
<?php
// Cantidad inválida
$resultado = $carrito->anadir(1, 0);
// ['exito' => false, 'mensaje' => 'La cantidad debe ser mayor que 0']

// Producto no existe
$resultado = $carrito->anadir(999, 1);
// ['exito' => false, 'mensaje' => 'Producto no encontrado en el catálogo']

// Stock insuficiente
$resultado = $carrito->anadir(1, 100);  // Solo hay 5 en stock
// ['exito' => false, 'mensaje' => 'Stock insuficiente. Disponible: 5 unidades']

// Sumar cantidad a producto existente
$carrito->anadir(1, 2);  // Añade 2
$carrito->anadir(1, 1);  // Suma 1 más = 3 total
?>
```

---

## 4. Consultar Información del Carrito

```php
<?php
// Cantidad total de unidades
echo $carrito->getNumeroUnidades();     // 5

// Número de productos distintos
echo $carrito->getNumeroLineas();       // 2

// ¿Está vacío?
echo $carrito->estaVacio() ? "Sí" : "No";

// Precio total
echo $carrito->calcularTotal();         // 1889.95
echo $carrito->getTotalFormateado();    // "1.889,95 €"

// IVA
echo $carrito->calcularIVA();           // 396.89
echo $carrito->calcularIVA(10);         // 188.995 (10% de IVA)

// Total con IVA
echo $carrito->calcularTotalConIVA();   // 2286.84
?>
```

---

## 5. Obtener Items del Carrito

### Formato detallado (para mostrar en tabla)

```php
<?php
foreach ($carrito->getItems() as $item) {
    $producto = $item['producto'];      // Objeto Producto
    $cantidad = $item['cantidad'];      // int
    $subtotal = $item['subtotal'];      // float
    
    echo $producto->getNombre();        // "Laptop"
    echo $cantidad;                     // 2
    echo $subtotal;                     // 1799.98
}
?>
```

### Formato interno (para guardar en sesión)

```php
<?php
$items = $carrito->getItemsRaw();
// [1 => 2, 2 => 3]  (id_producto => cantidad)

// Guardar en sesión
$_SESSION['carrito'] = $items;

// Recuperar de sesión
$nuevoCarrito = new Carrito($catalogo);
$nuevoCarrito->setItems($_SESSION['carrito']);
?>
```

---

## 6. Modificar el Carrito

### Eliminar un producto completamente

```php
<?php
if ($carrito->eliminar(2)) {
    echo "Producto eliminado";
} else {
    echo "No se pudo eliminar";
}
?>
```

### Reducir cantidad

```php
<?php
// Tenemos 3 unidades, reducir a 1
$resultado = $carrito->reducirCantidad(1, 2);

if ($resultado['exito']) {
    echo $resultado['mensaje'];
    // "Cantidad reducida a 1 unidades"
}

// Si reduces todo, se elimina la línea
$resultado = $carrito->reducirCantidad(1, 1);
// "Producto eliminado del carrito"
?>
```

### Vaciar completamente

```php
<?php
$carrito->vaciar();
echo $carrito->estaVacio() ? "Vacío" : "Con items";  // "Vacío"
?>
```

---

## 7. Serializar Producto (para guardar en sesión o BD)

```php
<?php
// Convertir a array
$producto = new Producto(1, 'Laptop', 899.99, 5, 'Descripción');
$datos = $producto->toArray();
// [
//     'id' => 1,
//     'nombre' => 'Laptop',
//     'precio' => 899.99,
//     'stock' => 5,
//     'descripcion' => 'Descripción'
// ]

// Guardar en JSON
$json = json_encode($datos);
file_put_contents('producto.json', $json);

// Recuperar y reconstruir
$datos = json_decode(file_get_contents('producto.json'), true);
$productoRecuperado = Producto::fromArray($datos);
?>
```

---

## 8. Caso de uso completo: Aplicación web

### En index.php (mostrar catálogo)

```php
<?php
require_once '../src/helpers.php';

use CarritoPOO\Carrito;

// Iniciar sesión
CarritoPOO\iniciarSesion();

// Crear catálogo
$catalogo = CarritoPOO\crearCatalogo();

// Obtener carrito de sesión
$carritoConCatalogo = new Carrito($catalogo);
$carrito = CarritoPOO\obtenerCarritoSesion($carritoConCatalogo);

// En HTML
foreach ($catalogo as $producto) {
    echo CarritoPOO\renderProducto($producto);
}

// Mostrar contador
if (!$carrito->estaVacio()) {
    echo "Carrito: " . $carrito->getNumeroUnidades() . " artículos";
}
?>
```

### En procesar.php (manejar POST)

```php
<?php
require_once '../src/helpers.php';

use CarritoPOO\Carrito;

CarritoPOO\iniciarSesion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catalogo = CarritoPOO\crearCatalogo();
    $carrito = new Carrito($catalogo);
    $carrito->setItems($_SESSION['carrito'] ?? []);
    
    $accion = $_POST['accion'] ?? null;
    
    if ($accion === 'anadir') {
        $id = (int)$_POST['producto_id'];
        $cantidad = (int)$_POST['cantidad'];
        
        $resultado = $carrito->anadir($id, $cantidad);
        
        if ($resultado['exito']) {
            $_SESSION['mensaje'] = $resultado['mensaje'];
            $_SESSION['tipo'] = 'exito';
        } else {
            $_SESSION['mensaje'] = $resultado['mensaje'];
            $_SESSION['tipo'] = 'error';
        }
        
        // Guardar carrito
        $_SESSION['carrito'] = $carrito->getItemsRaw();
    }
    
    header('Location: index.php');
    exit;
}
?>
```

---

## 9. Patrones y buenas prácticas

### ✅ Usar métodos públicos

```php
<?php
// ✅ Bien
$nombre = $producto->getNombre();

// ❌ Mal (propiedades son private)
// $nombre = $producto->nombre;
?>
```

### ✅ Validar antes de usar

```php
<?php
// ✅ Bien
$resultado = $carrito->anadir($id, $cantidad);
if ($resultado['exito']) {
    // Hacer algo
}

// ❌ Mal (suponer que siempre funciona)
// $carrito->anadir($id, $cantidad);
?>
```

### ✅ Usar getters para acceder a datos

```php
<?php
// ✅ Bien
echo $producto->getStock();
echo $producto->getPrecioFormateado();

// ❌ Mal
// echo $producto->stock;
// echo $producto->precio;
?>
```

### ✅ Separar responsabilidades

```php
<?php
// ✅ Bien (cada clase hace una cosa)
$producto = new Producto(...);           // Crea un producto
$carrito = new Carrito($catalogo);       // Crea un carrito
$resultado = $carrito->anadir(...);      // Añade al carrito

// ❌ Mal (todo mezclado)
// $producto->anadirAlCarrito();
// Mezcla responsabilidades
?>
```

---

## 10. Testing (pruebas unitarias)

```php
<?php
// Ejecutar: php test.php

require_once 'src/helpers.php';

use CarritoPOO\{Producto, Carrito};

// Test: Crear producto
$p = new Producto(1, 'Test', 10, 5);
assert($p->getId() === 1, "ID debe ser 1");
assert($p->getNombre() === 'Test', "Nombre debe ser 'Test'");
assert($p->getPrecio() === 10, "Precio debe ser 10");
assert($p->getStock() === 5, "Stock debe ser 5");
echo "✅ Test crear producto OK\n";

// Test: Validar stock
assert($p->tieneStockSuficiente(3), "Debe haber stock para 3");
assert(!$p->tieneStockSuficiente(10), "No debe haber stock para 10");
echo "✅ Test validar stock OK\n";

// Test: Carrito
$catalogo = [$p];
$c = new Carrito($catalogo);
$r = $c->anadir(1, 2);
assert($r['exito'], "Debe haber éxito al añadir");
assert($c->getNumeroUnidades() === 2, "Debe haber 2 unidades");
echo "✅ Test carrito OK\n";

echo "\n✅ TODOS LOS TESTS PASADOS\n";
?>
```

---

## 11. Evoluciones futuras

### Crear clase ProductoRepository

```php
<?php
namespace CarritoPOO;

class ProductoRepository {
    private PDO $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function obtenerTodos(): array {
        $stmt = $this->pdo->query('SELECT * FROM productos');
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(fn($d) => Producto::fromArray($d), $datos);
    }
    
    public function obtenerPorId(int $id): ?Producto {
        $stmt = $this->pdo->prepare('SELECT * FROM productos WHERE id = ?');
        $stmt->execute([$id]);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $datos ? Producto::fromArray($datos) : null;
    }
}
?>
```

### Usar herencia para productos distintos

```php
<?php
namespace CarritoPOO;

// Clase base
class Producto { /* ... */ }

// Producto físico
class ProductoFisico extends Producto {
    private float $peso;
    
    public function calcularEnvio(): float {
        return 5.99; // Envío base
    }
}

// Producto digital
class ProductoDigital extends Producto {
    private string $urlDescarga;
    
    public function calcularEnvio(): float {
        return 0; // Sin envío
    }
}

// El carrito funciona igual con ambos tipos
$carrito->anadir($idFisico, 1);
$carrito->anadir($idDigital, 1);
?>
```

---

**Última actualización**: 28/04/2026
