<?php

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombreLimpio = trim(htmlspecialchars($_POST['nombre'] ?? '', ENT_QUOTES, 'UTF-8'));
    $emailLimpio = trim(strtolower(htmlspecialchars($_POST['email'] ?? '')));
    $comentarioLimpio = trim(htmlspecialchars($_POST['comentario'] ?? ''));

    if (strlen($nombreLimpio) < 2 || strlen($nombreLimpio) > 50) {
        $errores[] = "Nombre no valido";
    }

    if (strlen($emailLimpio) < 5 || strlen($emailLimpio) > 100) {
        $errores[] = "Email no valido";
    }

    if (strlen($comentarioLimpio) < 10 || strlen($comentarioLimpio) > 500) {
        $errores[] = "Comentario no valido";
    }

    if (!empty($errores)) {

        foreach ($errores as $error) {
            echo "<p style='color:red;'>$error</p>";
        }

    } else {
        ?>
        <div class="comentario-wp">
            <strong><?php echo ucfirst($nombreLimpio); ?></strong>
            <em><?php echo $emailLimpio; ?></em>
            <p><?php echo $comentarioLimpio; ?></p>
        </div>
        <?php
    }
}

?>