<?php ob_start(); ?>

<h1>Carrito</h1>

<?php if ($carrito->estaVacio()): ?>
    <p>No hay productos en el carrito</p>
<?php else: ?>

<?php foreach ($carrito->getItems() as $item): ?>

<div class="cart-item">
    <div>
        <strong><?= $item['producto']->getNombre() ?></strong>
        <p><?= $item['cantidad'] ?> unidades</p>
    </div>

    <div>
        <?= $item['producto']->getPrecio() * $item['cantidad'] ?> €
    </div>
</div>

<?php endforeach; ?>

<div class="total">
    Total: <?= $carrito->calcularTotal() ?> €
</div>

<form method="POST" action="index.php?action=process">
    <input type="hidden" name="accion" value="vaciar">
    <button class="btn-danger">Vaciar carrito</button>
</form>

<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../views/layouts/main.php';
?>