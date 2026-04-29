<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Catálogo</h1>
    <?php if (!empty($message)): ?><p><?= $message ?></p><?php endif; ?>

    <ul>
        <?php foreach ($catalogo as $p): ?>
            <li><?= $p->summary() ?> 
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $p->id ?>">
                    <input type="number" name="cantidad" value="1" min='1'>
                    <button type="submit">Añadir</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <h2>Total: <?= number_format($total / 100, 2) ?> €</h2>
</body>
</html>