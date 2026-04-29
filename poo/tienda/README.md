# TechShop — Mini tienda PHP con arquitectura MVC

Proyecto de práctica en PHP puro (sin frameworks) que implementa un catálogo de productos y un carrito de compra persistente en sesión, organizado con una arquitectura MVC manual.

---

## Estructura de directorios

```
tienda/
├── config/
│   └── autoload.php        # Autoloader PSR-4 manual (sin Composer)
├── public/
│   ├── .htaccess           # Rewrite rules → todo pasa por index.php
│   └── index.php           # Punto de entrada + definición de rutas
└── src/
    ├── Router.php           # Router mínimo GET/POST
    ├── Controllers/
    │   ├── ProductoController.php
    │   └── CarritoController.php
    ├── Models/
    │   ├── Producto.php
    │   ├── Carrito.php
    │   └── ProductoRepositorio.php
    └── Views/
        ├── layouts/
        │   ├── header.php
        │   └── footer.php
        ├── productos/
        │   └── index.php
        └── carrito/
            └── index.php
```

---

## Clases principales

### `Producto` (`src/Models/Producto.php`)

Representa un artículo del catálogo.

| Elemento | Detalle |
|---|---|
| Propiedades | `id`, `nombre`, `precio` *(private)*, `stock`, `descripcion`, `categoria`, `imagen` |
| Constructor | Inicializa todos los campos; `precio` es `private` para forzar acceso a través del getter |
| `tieneSuficienteStock(int $cantidad): bool` | Comprueba si `stock >= $cantidad` |
| `getPrecio(): float` | Getter del precio privado |
| `getPrecioFormateado(): string` | Devuelve el precio con dos decimales y símbolo €, ej. `"49,50 €"` |
| `getResumen(): string` | Cadena corta `"Nombre — precio"` para uso en el carrito u otros contextos |

> **Decisión de diseño:** `precio` es `private` porque no debe modificarse directamente; cualquier acceso externo pasa por `getPrecio()` o `getPrecioFormateado()`.

---

### `Carrito` (`src/Models/Carrito.php`)

Gestiona el estado del carrito y lo persiste en `$_SESSION`.

| Elemento | Detalle |
|---|---|
| Propiedad | `items: array` *(private)* — mapa `[id => ['producto' => Producto, 'cantidad' => int]]` |
| `agregarProducto(Producto, int): array` | Valida cantidad > 0 y stock suficiente; devuelve `['ok', 'mensaje']` |
| `eliminarProducto(int): void` | Elimina una línea completa del carrito |
| `reducirCantidad(int, int): void` | Reduce cantidad; si llega a 0 elimina la línea |
| `vaciar(): void` | Limpia todo el carrito |
| `getCantidad(int): int` | Unidades de un producto concreto en el carrito |
| `getTotalUnidades(): int` | Suma de todas las cantidades |
| `getTotal(): float` | Precio total calculado |
| `getTotalFormateado(): string` | Total con formato `"xxx,xx €"` |
| `estaVacio(): bool` | `true` si no hay items |
| `guardarEnSesion(): void` | Serializa `$items` en `$_SESSION['carrito']` |
| `cargarDesdeSesion(): self` | Factory estático; reconstruye el carrito desde sesión |

> **Decisión de diseño:** la lógica de sesión está encapsulada en la propia clase (`guardarEnSesion` / `cargarDesdeSesion`) para que los controladores no tengan que conocer la implementación de persistencia. Si en el futuro se quiere guardar en base de datos, solo cambia esta clase.

---

### `ProductoRepositorio` (`src/Models/ProductoRepositorio.php`)

Fuente de datos de productos (Opción A: array hardcodeado).

| Método | Detalle |
|---|---|
| `getAll(): Producto[]` | Devuelve el catálogo completo como objetos `Producto` |
| `getById(int): ?Producto` | Busca un producto por ID; `null` si no existe |

> Para pasar a la **Opción B (PDO)** solo hay que reemplazar el contenido de `getAll()` por una consulta PDO. El resto de la aplicación no cambia.

---

## Flujo de una petición

```
Navegador  →  Apache  →  public/.htaccess  →  public/index.php
                                                     │
                                               Router::despachar()
                                                     │
                                          ┌──────────┴──────────┐
                                    GET /               POST /carrito/agregar
                                          │                      │
                               ProductoController        CarritoController
                                  ->index()                ->agregar()
                                          │                      │
                              ProductoRepositorio::getAll()    Carrito::cargarDesdeSesion()
                              Carrito::cargarDesdeSesion()     $carrito->agregarProducto(...)
                                          │                      │
                                    Views/productos/       $carrito->guardarEnSesion()
                                      index.php            redirect('/')
```

---

## Validaciones implementadas

- Cantidad `<= 0` → error, no se añade.
- Stock insuficiente considerando lo que ya hay en el carrito → error con mensaje descriptivo.
- `producto_id` inexistente en el repositorio → redirige con error.
- En la vista, el input `number` tiene `max="disponible"` para validación en cliente también.

---

## Pasos seguidos durante el desarrollo

1. **Estructura de carpetas** — separación clara entre `public/` (accesible), `src/` (lógica) y `config/`.
2. **Autoloader manual** — `config/autoload.php` registra un autoloader PSR-4 que mapea `App\` → `src/`. Sin Composer para mantener el proyecto autocontenido.
3. **Modelo `Producto`** — clase con constructor, propiedad privada y métodos de utilidad.
4. **Repositorio de productos** — datos de ejemplo como objetos `Producto`; desacoplado del controlador.
5. **Modelo `Carrito`** — lógica de carrito completa, incluyendo validaciones y persistencia en sesión.
6. **Router** — clase `Router` mínima que registra rutas GET/POST y las despacha.
7. **Controladores** — `ProductoController` y `CarritoController` sin lógica de negocio; delegan en los modelos.
8. **Vistas** — layouts `header.php` / `footer.php` + vistas específicas. Sin PHP mezclado con CSS/JS innecesariamente.
9. **Mensajes flash** — guardados en `$_SESSION['flash']` por el controlador y mostrados y eliminados en el header.

---

## Instalación en entorno LAMP / WSL

```bash
# 1. Copiar el proyecto a la raíz del servidor
sudo cp -r tienda/ /var/www/html/tienda

# 2. Asegurarse de que mod_rewrite está activo
sudo a2enmod rewrite
sudo systemctl restart apache2

# 3. Permitir .htaccess en el VirtualHost (AllowOverride All)
#    Edita /etc/apache2/sites-available/000-default.conf si es necesario

# 4. Abrir en el navegador
http://localhost/tienda/
```

> Si se usa el `public/` como DocumentRoot del VirtualHost, las URLs quedan más limpias: `http://localhost/` directamente.

---

## Posibles mejoras futuras

- [ ] Opción B: leer productos desde MySQL con PDO.
- [ ] Página de confirmación de pedido.
- [ ] Actualizar cantidad directamente desde el carrito.
- [ ] Tests unitarios para `Producto` y `Carrito` con PHPUnit.
- [ ] Migraciones y seeders de base de datos.
