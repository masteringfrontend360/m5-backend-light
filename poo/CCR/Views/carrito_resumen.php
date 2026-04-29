<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tu Carrito</h2>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver al catálogo</a>
</div>

<?php if (empty($itemsCarrito)): ?>
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <p class="mt-3">El carrito está vacío.</p>
    </div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unit.</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itemsCarrito as $id => $item): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($item['producto']->getNombre()) ?></strong></td>
                        <td class="text-center"><?= $item['cantidad'] ?></td>
                        <td class="text-end"><?= $item['producto']->getPrecioFormateado() ?></td>
                        <td class="text-end fw-bold">
                            <?= number_format($item['producto']->getPrecio() * $item['cantidad'], 2, ',', '.') ?> €
                        </td>
                        <td class="text-end">
                            </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-group-divider">
                    <tr>
                        <td colspan="3" class="text-end fs-5">Total:</td>
                        <td class="text-end fs-5 fw-bold text-primary"><?= number_format($total, 2, ',', '.') ?> €</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end gap-2">
        <form action="index.php" method="POST">
            <input type="hidden" name="action" value="vaciar">
            <button type="submit" class="btn btn-outline-danger">Vaciar Carrito</button>
        </form>
        <button class="btn btn-success px-5">Finalizar Compra</button>
    </div>
<?php endif; ?>