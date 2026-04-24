# Práctica: Catálogo y carrito con clases en PHP

## Estructura del proyecto
```
tienda-poo-pdo/
├── .env
├── .gitignore (este no lo vamos a incluir, ya está)
├── composer.json
├── database.sql
├── src/
├── Controller/          
│   ├── ProductoController.php
│   ├── CarritoController.php  
│   ├── AuthController.php
│   └── HomeController.php
│   ├── Config/
│   │   └── Database.php
│   ├── Entity/ ← Modelos de dominio (Producto, Usuario, Pedido) DDD 
│   │   └── Producto.php
│   ├── Repository/  ← Acceso a datos (ProductoRepository, UsuarioRepository)
│   │   └── ProductoRepository.php
│   └── Service/ ← Carrito, PedidoService, AuthService...
│       └── Carrito.php
└── public/
    ├── index.php
```
### Aclaraciones
- Controller - termediario que recibe las peticiones HTTP del navegador, interpreta qué hacer (leer/crear/actualizar/borrar), llama a los servicios para ejecutar la lógica y devuelve la respuesta (HTML/JSON) sin contener reglas de negocio ni acceso directo a base de datos.
- DDD - Domain-Driven Design. Clases que sirven para modelar la lógica del negocio, el dominio, no datos técnicos.
- Repository/ -  Es la capa que media entre la  lógica de negocio y la persistencia, ofreciendo una interfaz tipo “colección de objetos” para obtener y guardar entidades sin exponer directamente SQL o detalles de almacenamiento. ProductoRepository, por ejemplo, viene a decri: “esta clase se encarga de recuperar, buscar, guardar o borrar productos desde la fuente de datos.
- Service/ - Si un repositorio recupera o guarda datos; un servicio coordina reglas, validaciones y operaciones que pueden implicar varias clases o varios repositorios.
- public/ - Punto de entrada web y archivos expuestos al navegador