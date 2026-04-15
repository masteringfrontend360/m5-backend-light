<?php
session_start();

$errores = $_SESSION['errores'] ?? [];
$old = $_SESSION['old'] ?? [];
$exito = $_SESSION['exito'] ?? '';

unset($_SESSION['errores'], $_SESSION['old'], $_SESSION['exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario clásico con PHP</title>
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

        .intro {
            background: #eef4ff;
            border-left: 4px solid #2271b1;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .ok {
            background: #edfaef;
            border-left: 4px solid #00a32a;
            padding: 12px 16px;
            margin-bottom: 18px;
            border-radius: 6px;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input,
        button {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccd0d4;
            border-radius: 6px;
        }

        .hint {
            display: block;
            font-size: 14px;
            color: #666;
            margin-top: 6px;
        }

        .error {
            margin-top: 8px;
            background: #fff1f1;
            border-left: 4px solid #d63638;
            padding: 10px 12px;
            border-radius: 6px;
            color: #7a1f1f;
        }

        .input-error {
            border-color: #d63638;
            background: #fff8f8;
        }

        button {
            background: #0073aa;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            width: auto;
            padding: 12px 18px;
        }

        button:hover {
            background: #005f8d;
        }

        .mini-box {
            background: #f6f7f7;
            border-left: 4px solid #72aee6;
            padding: 14px 16px;
            border-radius: 6px;
            margin-top: 20px;
        }

        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
        }

        ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>Ejercicio 01 · Validación clásica con sesión</h1>

    <div class="intro">
        <p><strong>Objetivo:</strong> validar un formulario en PHP con el flujo clásico de servidor: enviar datos, procesarlos, guardar errores en sesión y volver al formulario repoblando los campos.</p>
        <p>En este ejemplo trabajamos <code>trim()</code>, <code>strlen()</code>, <code>preg_match()</code>, <code>filter_var()</code>, <code>session_start()</code> y <code>htmlspecialchars()</code>.</p>
    </div>

    <?php if ($exito !== ''): ?>
        <div class="ok">
            <?php echo htmlspecialchars($exito, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <h2>Formulario de prueba</h2>

    <form action="proceso.php" method="POST" novalidate>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                class="<?php echo isset($errores['nombre']) ? 'input-error' : ''; ?>"
                value="<?php echo htmlspecialchars($old['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            >
            <span class="hint">Obligatorio. Entre 2 y 50 caracteres. Solo letras, espacios, apóstrofes y guiones.</span>

            <?php if (isset($errores['nombre'])): ?>
                <div class="error">
                    <?php echo htmlspecialchars($errores['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="<?php echo isset($errores['email']) ? 'input-error' : ''; ?>"
                value="<?php echo htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            >
            <span class="hint">Obligatorio. Entre 5 y 100 caracteres. Debe tener un formato de email válido.</span>

            <?php if (isset($errores['email'])): ?>
                <div class="error">
                    <?php echo htmlspecialchars($errores['email'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit">Validar formulario</button>
    </form>

    <div class="mini-box">
        <h2>Qué está pasando aquí</h2>
        <ul>
            <li>El formulario envía los datos por <code>POST</code> a <code>proceso.php</code>.</li>
            <li>Si hay errores, se guardan en <code>$_SESSION['errores']</code>.</li>
            <li>Los valores escritos por el usuario se guardan en <code>$_SESSION['old']</code>.</li>
            <li>Al volver al formulario, los inputs se rellenan otra vez y los errores aparecen debajo de cada campo.</li>
        </ul>
    </div>

    <div class="mini-box">
        <h2>Pruebas recomendadas</h2>
        <p>
            Nombre válido: <code>Ana García</code><br>
            Nombre inválido: <code>A1</code><br>
            Email válido: <code>ana@ejemplo.com</code><br>
            Email inválido: <code>ana.ejemplo.com</code>
        </p>
    </div>
</div>

</body>
</html>