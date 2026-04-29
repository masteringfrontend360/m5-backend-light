<section class="page-head">
    <h1>Carrito</h1>
    <p>Resumen actual del carrito.</p>
    <p><strong>Total de unidades:</strong> <?= $cartItemsCount ?></p>
</section>

<?php if (empty($items)): ?>
    <div class="card">
        <p>El carrito está vacío.</p>
    </div>
<?php else: ?>
    <section class="cart-list">
        <?php foreach ($items as $item): ?>
            <article class="card">
                <h2><?= htmlspecialchars($item->getProduct()->getName()) ?></h2>
                <p><strong>Precio unitario:</strong> <?= number_format($item->getProduct()->getPrice(), 2, ',', '.') ?> €</p>
                <p><strong>Cantidad:</strong> <?= $item->getQuantity() ?></p>
                <p><strong>Subtotal:</strong> <?= number_format($item->getSubtotal(), 2, ',', '.') ?> €</p>
            </article>
        <?php endforeach; ?>
    </section>

    <section class="cart-total">
        <div class="card">
            <h2>Total</h2>
            <p><?= number_format($total, 2, ',', '.') ?> €</p>
        </div>
    </section>
<?php endif; ?>