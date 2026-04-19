<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir contacto</title>
    <style>body{font-family:sans-serif;max-width:600px;margin:2rem auto;padding:1rem;}</style>
</head>
<body>
    <h1>📧 Añadir contacto</h1>
    
    <form action="guardar.php" method="POST">
        <p>
            <label>Nombre: 
                <input type="text" name="nombre" required maxlength="100">
            </label>
        </p>
        <p>
            <label>Email: 
                <input type="email" name="email" required maxlength="100">
            </label>
        </p>
        <p>
            <label>Ciudad: 
                <input type="text" name="ciudad" maxlength="50">
            </label>
        </p>
        <button type="submit">💾 Guardar contacto</button>
    </form>
    
    <p style="margin-top:2rem;">
        <a href="listado.php">📋 Ver todos los contactos</a>
    </p>
</body>
</html>