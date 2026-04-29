<section class="page-head">
    <h1>Catálogo</h1>
    <p>Productos disponibles en la tienda.</p>
    <p><strong>Productos en el carrito:</strong> <?= $cartItemsCount ?></p>
</section>

<section class="product-grid">
    <?php foreach ($products as $product): ?>
        <article class="card">
            <h2><?= htmlspecialchars($product->getName()) ?></h2>
            <p><strong>Precio:</strong> <?= number_format($product->getPrice(), 2, ',', '.') ?> €</p>
            <p><strong>Stock:</strong> <?= $product->getStock() ?></p>

            <form action="index.php" method="POST" class="product-form">
                <input type="hidden" name="action" value="add-to-cart">
                <input type="hidden" name="product_id" value="<?= $product->getId() ?>">

                <label for="quantity-<?= $product->getId() ?>">Cantidad</label>
                <input
                    id="quantity-<?= $product->getId() ?>"
                    type="number"
                    name="quantity"
                    min="1"
                    max="<?= $product->getStock() ?>"
                    value="1"
                    required
                >

                <button type="submit">Añadir al carrito</button>
            </form>
        </article>
    <?php endforeach; ?>
</section>