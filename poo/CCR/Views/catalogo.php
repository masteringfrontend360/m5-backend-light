<h2 class="mb-4">Catálogo de Productos</h2>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($productos as $p): ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($p->getNombre()) ?></h5>
                <p class="text-primary fw-bold fs-4"><?= $p->getPrecioFormateado() ?></p>
                <p class="card-text text-muted">Stock disponible: <?= $p->getStock() ?></p>
            </div>
            <div class="card-footer bg-white border-top-0">
                <form action="index.php" method="POST" class="row g-2">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?= $p->getId() ?>">
                    <div class="col-4">
                        <input type="number" name="cantidad" value="1" min="1" max="<?= $p->getStock() ?>" class="form-control">
                    </div>
                    <div class="col-8">
                        <button type="submit" class="btn btn-primary w-100 <?= !$p->hayStock(1) ? 'disabled' : '' ?>">
                            <i class="bi bi-plus-lg"></i> Añadir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>