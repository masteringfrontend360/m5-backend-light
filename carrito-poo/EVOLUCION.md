# Evolución del Proyecto - Roadmap

Este documento describe cómo hacer evolucionar la aplicación desde la versión actual hacia un sistema más robusto y profesional.

---

## Fase 1: Refactorización Actual (COMPLETADA)

### ✅ Lo que ya tenemos

- ✅ Clase `Producto` con propiedades privadas
- ✅ Clase `Carrito` con gestión de items
- ✅ Validación de stock y cantidades
- ✅ Persistencia en sesión
- ✅ Interfaz web con Bootstrap
- ✅ Funciones auxiliares reutilizables
- ✅ Autoloader de clases
- ✅ Tests unitarios

---

## Fase 2: Base de Datos (PRÓXIMO PASO)

### Crear tabla de productos

```sql
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    categoria_id INT,
    imagen_url VARCHAR(255),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT true
);
```

### Crear clase ProductoRepository

```php
namespace CarritoPOO\Infrastructure;

use CarritoPOO\Domain\Producto;
use PDO;

class ProductoRepository {
    private PDO $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function obtenerTodos(): array {
        $stmt = $this->pdo->query('SELECT * FROM productos WHERE activo = 1');
        return array_map(
            fn($datos) => Producto::fromArray($datos),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
    
    public function obtenerPorId(int $id): ?Producto {
        $stmt = $this->pdo->prepare('SELECT * FROM productos WHERE id = ?');
        $stmt->execute([$id]);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $datos ? Producto::fromArray($datos) : null;
    }
    
    public function buscar(string $termino): array {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ?'
        );
        $termino = "%{$termino}%";
        $stmt->execute([$termino, $termino]);
        return array_map(
            fn($datos) => Producto::fromArray($datos),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
```

### Conectar con la BD

```php
// En public/index.php
$pdo = new PDO('mysql:host=localhost;dbname=tienda_poo', 'root', '');
$repository = new ProductoRepository($pdo);
$catalogo = $repository->obtenerTodos();
```

---

## Fase 3: Productos con Tipos (Herencia)

### Problema

Algunos productos son físicos, otros digitales. Se comportan distinto:

- **Físico**: Necesita envío, ocupar espacio, perece
- **Digital**: Sin envío, descarga instantánea, no perece

### Solución: Herencia

```php
namespace CarritoPOO\Domain;

// Clase base
abstract class Producto {
    protected int $id;
    protected string $nombre;
    protected float $precio;
    protected int $stock;
    
    // Métodos comunes...
    
    // Método abstracto (implementado en subclases)
    abstract public function calcularCostoEnvio(): float;
}

// Producto físico
class ProductoFisico extends Producto {
    private float $peso;
    private float $dimensiones;
    
    public function calcularCostoEnvio(): float {
        // Basado en peso y distancia
        return $this->peso * 0.5 + 5;
    }
}

// Producto digital
class ProductoDigital extends Producto {
    private string $urlDescarga;
    
    public function calcularCostoEnvio(): float {
        return 0; // Sin envío
    }
    
    public function obtenerUrlDescarga(): string {
        return $this->urlDescarga;
    }
}
```

### El carrito sigue funcionando igual

```php
$carrito->anadir($idFisico, 1);      // ProductoFisico
$carrito->anadir($idDigital, 1);     // ProductoDigital
$carrito->calcularTotal();            // Funciona igual
```

---

## Fase 4: Usuarios y Autenticación

### Tabla de usuarios

```sql
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Clase Usuario

```php
namespace CarritoPOO\Domain;

class Usuario {
    private int $id;
    private string $email;
    private string $nombre;
    private string $contraseña;
    
    public function __construct(int $id, string $email, string $nombre, string $contraseña) {
        $this->id = $id;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
    }
    
    public function verificarContraseña(string $input): bool {
        return password_verify($input, $this->contraseña);
    }
}
```

### Autenticación en sesión

```php
// login.php
if ($usuario->verificarContraseña($inputContraseña)) {
    $_SESSION['usuario_id'] = $usuario->getId();
    $_SESSION['usuario_email'] = $usuario->getEmail();
    header('Location: index.php');
}
```

---

## Fase 5: Historial de Compras

### Tabla de pedidos

```sql
CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(50) DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE pedido_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
```

### Guardar pedido desde carrito

```php
public function guardarPedido(Carrito $carrito, Usuario $usuario): int {
    // Insertar pedido
    $stmt = $this->pdo->prepare(
        'INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)'
    );
    $stmt->execute([
        $usuario->getId(),
        $carrito->calcularTotalConIVA()
    ]);
    $pedidoId = $this->pdo->lastInsertId();
    
    // Insertar items
    foreach ($carrito->getItems() as $item) {
        $stmt = $this->pdo->prepare(
            'INSERT INTO pedido_items (pedido_id, producto_id, cantidad, precio_unitario)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $pedidoId,
            $item['producto']->getId(),
            $item['cantidad'],
            $item['producto']->getPrecio()
        ]);
    }
    
    return $pedidoId;
}
```

---

## Fase 6: Sistema de Descuentos

### Tabla de cupones

```sql
CREATE TABLE cupones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT,
    tipo_descuento ENUM('porcentaje', 'fijo') DEFAULT 'porcentaje',
    valor_descuento DECIMAL(10, 2) NOT NULL,
    uso_maximo INT DEFAULT 1,
    usos INT DEFAULT 0,
    valido_desde DATE,
    valido_hasta DATE,
    activo BOOLEAN DEFAULT true
);
```

### Clase Cupón

```php
namespace CarritoPOO\Domain;

class Cupon {
    private string $codigo;
    private float $valorDescuento;
    private string $tipoDescuento; // 'porcentaje' o 'fijo'
    
    public function calcularDescuento(float $total): float {
        if ($this->tipoDescuento === 'porcentaje') {
            return $total * ($this->valorDescuento / 100);
        }
        return $this->valorDescuento;
    }
    
    public function isValido(): bool {
        // Verificar fechas, usos, estado...
        return true;
    }
}
```

### Aplicar al carrito

```php
class Carrito {
    private ?Cupon $cupon = null;
    
    public function aplicarCupon(Cupon $cupon): bool {
        if (!$cupon->isValido()) {
            return false;
        }
        $this->cupon = $cupon;
        return true;
    }
    
    public function calcularTotalConDescuento(): float {
        $total = $this->calcularTotal();
        if ($this->cupon) {
            $total -= $this->cupon->calcularDescuento($total);
        }
        return $total;
    }
}
```

---

## Fase 7: API REST

### Endpoints sugeridos

```
GET  /api/productos               - Listar productos
GET  /api/productos/:id            - Obtener producto
POST /api/carrito/items            - Añadir al carrito
GET  /api/carrito                  - Ver carrito
DELETE /api/carrito/items/:id      - Eliminar del carrito
POST /api/pedidos                  - Crear pedido
GET  /api/pedidos/:id              - Ver pedido
```

### Implementación

```php
// api/productos.php
header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

if ($metodo === 'GET') {
    if ($id) {
        $producto = $repository->obtenerPorId($id);
        echo json_encode($producto->toArray());
    } else {
        $productos = $repository->obtenerTodos();
        echo json_encode(array_map(fn($p) => $p->toArray(), $productos));
    }
} elseif ($metodo === 'POST') {
    $datos = json_decode(file_get_contents('php://input'), true);
    // Crear producto...
}
```

---

## Fase 8: Búsqueda Avanzada y Filtros

### Filtros

```php
class ProductoFiltro {
    public ?float $precioMin = null;
    public ?float $precioMax = null;
    public ?string $categoria = null;
    public ?string $orden = null;
    
    public function aplicar(ProductoRepository $repo): array {
        return $repo->filtrar($this);
    }
}

// Uso
$filtro = new ProductoFiltro();
$filtro->precioMin = 50;
$filtro->precioMax = 500;
$filtro->categoria = 'Electrónica';
$filtro->orden = 'precio_asc';

$productos = $filtro->aplicar($repository);
```

---

## Fase 9: Tests Unitarios con PHPUnit

### Instalar PHPUnit

```bash
composer require --dev phpunit/phpunit
```

### Escribir tests

```php
// tests/ProductoTest.php
use PHPUnit\Framework\TestCase;
use CarritoPOO\Producto;

class ProductoTest extends TestCase {
    public function testCrearProducto() {
        $p = new Producto(1, 'Test', 10, 5);
        $this->assertEquals('Test', $p->getNombre());
        $this->assertEquals(10, $p->getPrecio());
    }
    
    public function testValidarStock() {
        $p = new Producto(1, 'Test', 10, 5);
        $this->assertTrue($p->tieneStockSuficiente(3));
        $this->assertFalse($p->tieneStockSuficiente(10));
    }
}
```

### Ejecutar tests

```bash
./vendor/bin/phpunit
```

---

## Fase 10: Inyección de Dependencias

### Usar un contenedor DI

```php
namespace CarritoPOO;

class Container {
    private array $servicios = [];
    
    public function registrar(string $nombre, callable $factory) {
        $this->servicios[$nombre] = $factory;
    }
    
    public function obtener(string $nombre) {
        if (!isset($this->servicios[$nombre])) {
            throw new Exception("Servicio no encontrado: $nombre");
        }
        return $this->servicios[$nombre]($this);
    }
}

// Configurar
$container = new Container();

$container->registrar('pdo', fn($c) => 
    new PDO('mysql:host=localhost;dbname=tienda_poo', 'root', '')
);

$container->registrar('productoRepository', fn($c) =>
    new ProductoRepository($c->obtener('pdo'))
);

// Usar
$repo = $container->obtener('productoRepository');
```

---

## Estructura Recomendada Futura

```
carrito-poo/
├── config/
│   ├── config.php
│   ├── database.php
│   └── container.php
├── src/
│   ├── Domain/
│   │   ├── Producto.php
│   │   ├── ProductoFisico.php
│   │   ├── ProductoDigital.php
│   │   ├── Carrito.php
│   │   ├── Usuario.php
│   │   ├── Pedido.php
│   │   └── Cupon.php
│   ├── Infrastructure/
│   │   ├── ProductoRepository.php
│   │   ├── UsuarioRepository.php
│   │   ├── PedidoRepository.php
│   │   └── CuponRepository.php
│   └── helpers.php
├── public/
│   ├── index.php
│   ├── carrito.php
│   ├── procesar.php
│   ├── login.php
│   ├── registro.php
│   ├── perfil.php
│   └── api/
│       ├── productos.php
│       ├── carrito.php
│       └── pedidos.php
├── tests/
│   ├── ProductoTest.php
│   ├── CarritoTest.php
│   └── bootstrap.php
├── vendor/          (Composer)
├── logs/
├── sessions/
├── .gitignore
├── .env.example
├── composer.json
└── README.md
```

---

## Timeline Sugerido

| Fase | Tiempo | Descripción |
|------|--------|-------------|
| 1 | DONE | Estructura actual con clases |
| 2 | 1 semana | Base de datos y repositorio |
| 3 | 1 semana | Herencia (físico/digital) |
| 4 | 1 semana | Usuarios y autenticación |
| 5 | 2 días | Historial de compras |
| 6 | 1 semana | Sistema de descuentos |
| 7 | 1 semana | API REST |
| 8 | 1 semana | Búsqueda y filtros |
| 9 | 3 días | Tests unitarios |
| 10 | 2 días | Inyección de dependencias |

---

## Conclusión

Esta aplicación está perfectamente posicionada para crecer. Cada fase se puede implementar independientemente sin romper lo anterior.

La estructura actual con **clases bien definidas y responsabilidades claras** permite que el proyecto escale sin convertirse en caos.

**Recordar**: La POO no es para hacer el código complicado, sino para hacerlo **más claro, reutilizable y mantenible**.

---

**Última actualización**: 28/04/2026
