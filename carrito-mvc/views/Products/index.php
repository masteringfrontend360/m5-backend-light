<?php ob_start(); ?>

<h1>Catálogo de productos</h1>

<?php foreach ($catalogo as $p): ?>

<div class="producto">
    <div>
        <h3><?= $p->getNombre() ?></h3>
        <p><?= $p->getPrecio() ?> €</p>
        <p>Stock: <?= $p->getStock() ?></p>
    </div>

    <form method="POST" action="index.php?action=process">
        <input type="hidden" name="accion" value="anadir">
        <input type="hidden" name="producto_id" value="<?= $p->getId() ?>">
        <input type="number" name="cantidad" min="1" value="1">
        <button>Añadir</button>
    </form>
</div>

<?php endforeach; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>