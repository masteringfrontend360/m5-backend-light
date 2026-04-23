## Ejercicio 1: Procesador de comentarios WordPress

### Nivel
Básico - Refuerza `trim()`, `htmlspecialchars()`, `strlen()` y `empty()`.

### Enunciado

Crea un fichero `procesar-comentario.php` en `php-fundamentos/funciones-predefinidas/10-comentarios-wp/` que:

#### 1. Reciba datos de formulario
_ `$_POST['nombre']`  
_ `$_POST['email']`  
_ `$_POST['comentario']`

#### 2. Aplique limpieza básica

```php
$nombreLimpio = trim(htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8'));
$emailLimpio = trim(strtolower(htmlspecialchars($_POST['email'] ?? '')));
$comentarioLimpio = trim(htmlspecialchars($_POST['comentario'] ?? ''));
```

#### 3. Valide longitud
_ Nombre: 2-50 caracteres (`strlen($nombreLimpio)` debe estar entre 2 y 50)  
_ Email: 5-100 caracteres  
_ Comentario: 10-500 caracteres  

Si alguna validación falla, muestra un mensaje de error específico y no procesa el comentario.

#### 4. Muestre resultado formateado como comentario WordPress

Si todas las validaciones pasan, muestra:

```php
<div class="comentario-wp">
    <strong><?php echo ucfirst($nombreLimpio); ?></strong>
    <em><?php echo $emailLimpio; ?></em>
    <p><?php echo $comentarioLimpio; ?></p>
</div>
```

### form-comentario.html

```html
<!DOCTYPE html>
<html>
<head>
    <title>Prueba comentarios WP</title>
    <style>
        .comentario-wp { 
            border-left: 4px solid #0073aa; 
            padding: 1rem; 
            margin: 1rem 0; 
            background: #f9f9f9; 
        }
    </style>
</head>
<body>
    <h1>Prueba procesador de comentarios</h1>
    <form method="POST" action="procesar-comentario.php">
        <p>
            <label>Nombre: <input name="nombre" required></label>
        </p>
        <p>
            <label>Email: <input name="email" type="email" required></label>
        </p>
        <p>
            <label>Comentario: 
                <textarea name="comentario" rows="4" required></textarea>
            </label>
        </p>
        <button type="submit">Publicar comentario</button>
    </form>
</body>
</html>
```

### Pruebas recomendadas

_ **Datos válidos:** `Ana García`, `ana@ejemplo.com`, comentario de 20 caracteres.  
_ **Nombre corto:** `A` (debe fallar).  
_ **Nombre largo:** 60 caracteres (debe fallar).  
_ **Email sin arroba:** `ana.ejemplo.com` (debe fallar).  
_ **Espacios extra:** `"  Ana  "`, `"ANA@EMAIL.COM"` (debe limpiarse correctamente).  

### Funciones que debes usar

_ `trim()` - Quitar espacios  
_ `htmlspecialchars()` - Sanitizar HTML  
_ `strlen()` - Validar longitud  
_ `empty()` - Comprobar campos vacíos  
_ `ucfirst()` - Formatear nombre  
_ `strtolower()` - Normalizar email  

---