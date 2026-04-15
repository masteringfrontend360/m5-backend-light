<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$nombreOriginal = $_POST['nombre'] ?? '';
$emailOriginal = $_POST['email'] ?? '';
$comentarioOriginal = $_POST['comentario'] ?? '';

// Limpieza básica
$nombreLimpio = trim(htmlspecialchars($nombreOriginal, ENT_QUOTES, 'UTF-8'));
$emailLimpio = trim(strtolower(htmlspecialchars($emailOriginal, ENT_QUOTES, 'UTF-8')));
$comentarioLimpio = trim(htmlspecialchars($comentarioOriginal, ENT_QUOTES, 'UTF-8'));

$errores = [];

// Validar que se ha enviado por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errores[] = 'No se ha enviado el formulario correctamente.';
}

// Validar nombre
if (empty($nombreLimpio)) {
    $errores[] = 'El nombre no puede estar vacío.';
} elseif (strlen($nombreLimpio) < 2) {
    $errores[] = 'El nombre debe tener al menos 2 caracteres.';
} elseif (strlen($nombreLimpio) > 50) {
    $errores[] = 'El nombre no puede superar los 50 caracteres.';
}

// Validar email
if (empty($emailLimpio)) {
    $errores[] = 'El email no puede estar vacío.';
} elseif (strlen($emailLimpio) < 5) {
    $errores[] = 'El email debe tener al menos 5 caracteres.';
} elseif (strlen($emailLimpio) > 100) {
    $errores[] = 'El email no puede superar los 100 caracteres.';
} elseif (!filter_var($emailLimpio, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El email no tiene un formato válido.';
}

// Validar comentario
if (empty($comentarioLimpio)) {
    $errores[] = 'El comentario no puede estar vacío.';
} elseif (strlen($comentarioLimpio) < 10) {
    $errores[] = 'El comentario debe tener al menos 10 caracteres.';
} elseif (strlen($comentarioLimpio) > 500) {
    $errores[] = 'El comentario no puede superar los 500 caracteres.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del comentario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
            color: #333;
        }

        .box {
            background: #ffffff;
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            max-width: 860px;
        }

        h1, h2 {
            margin-top: 0;
            color: #1d2327;
        }

        p {
            line-height: 1.6;
        }

        .explicacion {
            background: #eef4ff;
            border-left: 4px solid #2271b1;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #fff1f1;
            border-left: 4px solid #d63638;
            padding: 12px 16px;
            margin-bottom: 12px;
            border-radius: 6px;
        }

        .ok {
            background: #edfaef;
            border-left: 4px solid #00a32a;
            padding: 12px 16px;
            margin-bottom: 18px;
            border-radius: 6px;
        }

        .comentario-wp {
            border-left: 4px solid #0073aa;
            padding: 16px;
            margin: 18px 0;
            background: #f9f9f9;
            border-radius: 6px;
        }

        .comentario-wp strong {
            display: block;
            font-size: 18px;
            margin-bottom: 6px;
        }

        .comentario-wp em {
            display: block;
            color: #666;
            margin-bottom: 12px;
        }

        .resultado {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 16px;
        }

        .debug {
            background: #fff8e5;
            border-left: 4px solid #dba617;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 18px;
        }

        .acciones {
            margin-top: 20px;
        }

        .boton {
            display: inline-block;
            text-decoration: none;
            background: #0073aa;
            color: white;
            padding: 10px 14px;
            border-radius: 6px;
            margin-right: 10px;
        }

        .boton:hover {
            background: #005f8d;
        }

        .boton-secundario {
            background: #50575e;
        }

        .boton-secundario:hover {
            background: #3c434a;
        }

        ul {
            padding-left: 20px;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .reintento-form {
            margin-top: 20px;
            background: #f9f9f9;
            border-left: 4px solid #d63638;
            padding: 18px;
            border-radius: 6px;
        }

        .campo {
            margin-bottom: 16px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input,
        textarea,
        button {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccd0d4;
            border-radius: 6px;
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        button {
            width: auto;
            background: #d63638;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            padding: 12px 18px;
        }

        button:hover {
            background: #b32d2e;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>Procesador de comentarios WordPress</h1>

        <div class="explicacion">
            <p><strong>Qué hace este archivo:</strong> recibe los datos del formulario, los limpia, comprueba si cumplen las reglas del ejercicio y después muestra errores o el comentario ya formateado.</p>
        </div>

        <?php if (!empty($errores)): ?>
            <h2>Se han encontrado errores</h2>

            <?php foreach ($errores as $error): ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <div class="reintento-form">
                <h2>Corrige los datos y vuelve a probar</h2>

                <form method="POST" action="">
                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="<?php echo htmlspecialchars($nombreOriginal, ENT_QUOTES, 'UTF-8'); ?>"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="email">Email</label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            value="<?php echo htmlspecialchars($emailOriginal, ENT_QUOTES, 'UTF-8'); ?>"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="comentario">Comentario</label>
                        <textarea id="comentario" name="comentario" required><?php echo htmlspecialchars($comentarioOriginal, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <button type="submit">Volver a intentar</button>
                </form>
            </div>

        <?php else: ?>
            <div class="ok">
                <strong>Comentario procesado correctamente.</strong>
            </div>

            <h2>Vista previa estilo WordPress</h2>

            <div class="comentario-wp">
                <strong><?php echo ucfirst($nombreLimpio); ?></strong>
                <em><?php echo $emailLimpio; ?></em>
                <p><?php echo $comentarioLimpio; ?></p>
            </div>

            <div class="resultado">
                <p><strong>Resumen didáctico:</strong></p>
                <ul>
                    <li><code>trim()</code> elimina espacios al principio y al final.</li>
                    <li><code>htmlspecialchars()</code> evita que se interprete HTML enviado por el usuario.</li>
                    <li><code>strlen()</code> comprueba la longitud de cada campo.</li>
                    <li><code>empty()</code> detecta campos vacíos.</li>
                    <li><code>strtolower()</code> normaliza el email a minúsculas.</li>
                    <li><code>ucfirst()</code> pone en mayúscula la primera letra del nombre mostrado.</li>
                </ul>
            </div>

            <div class="debug">
                <p><strong>Valores procesados:</strong></p>
                <p>Nombre limpio: <code><?php echo $nombreLimpio; ?></code></p>
                <p>Email limpio: <code><?php echo $emailLimpio; ?></code></p>
                <p>Longitud del comentario: <code><?php echo strlen($comentarioLimpio); ?></code> caracteres</p>
            </div>

            <div class="acciones">
                <a class="boton" href="form-comentario.html">Volver al formulario inicial</a>
                <a class="boton boton-secundario" href="procesar-comentario.php">Recargar procesador</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>