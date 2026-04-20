<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir contacto</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; padding: 1rem; }
        input, button { font: inherit; padding: 0.5rem; }
        input { width: 100%; max-width: 100%; box-sizing: border-box; }
        p { margin-bottom: 1rem; }
        #mensaje { padding: 0.5rem; border-radius: 4px; display: none; }
        #mensaje.ok  { background: #d4edda; color: #155724; }
        #mensaje.err { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>📧 Añadir contacto</h1>

    <div id="mensaje"></div>

    <!-- Sin action ni method: JS intercepta el submit -->
    <form id="form-contacto" novalidate>
        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required maxlength="100">
        </p>
        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required maxlength="100">
        </p>
        <p>
            <label for="ciudad">Ciudad:</label><br>
            <input type="text" id="ciudad" name="ciudad" maxlength="50">
        </p>
        <button type="submit" id="btn-guardar">💾 Guardar contacto</button>
    </form>

    <p><a href="listado.php">📋 Ver todos los contactos</a></p>

    <script src="contactos.js"></script>
</body>
</html>