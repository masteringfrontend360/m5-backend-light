<style>
  /* ── Grid catálogo ── */
  .catalogo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
  }

  /* ── Tarjeta ── */
  .tarjeta {
    background: var(--gris1);
    border: 1px solid var(--gris2);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform .2s, border-color .2s;
  }

  .tarjeta:hover { transform: translateY(-4px); border-color: var(--gris3); }

  .tarjeta-icono {
    background: var(--gris2);
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    position: relative;
  }

  .tarjeta-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--gris1);
    border: 1px solid var(--gris2);
    border-radius: 20px;
    font-size: .72rem;
    color: var(--gris3);
    padding: 2px 9px;
  }

  .tarjeta-body { padding: 1.1rem 1.2rem; flex: 1; display: flex; flex-direction: column; gap: .4rem; }

  .tarjeta-nombre {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    line-height: 1.3;
  }

  .tarjeta-desc { font-size: .82rem; color: var(--gris3); line-height: 1.5; flex: 1; }

  .tarjeta-footer {
    padding: 1rem 1.2rem;
    border-top: 1px solid var(--gris2);
    display: flex;
    align-items: center;
    gap: .8rem;
  }

  .tarjeta-precio {
    font-family: 'Syne', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--acento2);
    white-space: nowrap;
  }

  .tarjeta-stock-ok   { font-size: .75rem; color: #86efac; }
  .tarjeta-stock-bajo { font-size: .75rem; color: var(--acento2); }
  .tarjeta-stock-no   { font-size: .75rem; color: #f87171; }

  /* ── Formulario add-to-cart ── */
  .form-add {
    display: flex;
    gap: .5rem;
    align-items: center;
    flex: 1;
    justify-content: flex-end;
  }

  .qty-input {
    width: 52px;
    background: var(--gris2);
    border: 1px solid var(--gris3);
    border-radius: var(--radio);
    color: var(--blanco);
    padding: .4rem .5rem;
    font-size: .85rem;
    text-align: center;
    outline: none;
    appearance: none;
    -moz-appearance: textfield;
  }

  .qty-input:focus { border-color: var(--acento); }
  .qty-input::-webkit-outer-spin-button,
  .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

  .btn-add {
    background: var(--acento);
    color: var(--blanco);
    border: none;
    border-radius: var(--radio);
    padding: .45rem .9rem;
    font-size: .82rem;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s;
  }

  .btn-add:hover  { background: #c93d15; }
  .btn-add:disabled { background: var(--gris2); color: var(--gris3); cursor: not-allowed; }
</style>

<h1 class="titulo-seccion">Nuestro <em>catálogo</em></h1>

<div class="catalogo-grid">
<?php foreach ($productos as $p): ?>
  <?php
    $iconos = [
      'Periféricos'    => '⌨️',
      'Monitores'      => '🖥️',
      'Audio'          => '🎧',
      'Almacenamiento' => '💾',
      'Accesorios'     => '🔌',
    ];
    $icono = $iconos[$p->categoria] ?? '📦';
    $sinStock = $p->stock === 0;
    $stockBajo = !$sinStock && $p->stock <= 5;
    $enCarrito = $carrito->getCantidad($p->id);
    $disponible = $p->stock - $enCarrito;
  ?>
  <div class="tarjeta">
    <div class="tarjeta-icono">
      <?= $icono ?>
      <span class="tarjeta-badge"><?= htmlspecialchars($p->categoria) ?></span>
    </div>
    <div class="tarjeta-body">
      <div class="tarjeta-nombre"><?= htmlspecialchars($p->nombre) ?></div>
      <div class="tarjeta-desc"><?= htmlspecialchars($p->descripcion) ?></div>
      <?php if ($sinStock): ?>
        <span class="tarjeta-stock-no">✗ Sin stock</span>
      <?php elseif ($stockBajo): ?>
        <span class="tarjeta-stock-bajo">⚠ Últimas <?= $p->stock ?> unidades</span>
      <?php else: ?>
        <span class="tarjeta-stock-ok">✓ En stock (<?= $p->stock ?>)</span>
      <?php endif; ?>
    </div>
    <div class="tarjeta-footer">
      <span class="tarjeta-precio"><?= $p->getPrecioFormateado() ?></span>
      <?php if (!$sinStock && $disponible > 0): ?>
        <form method="POST" action="<?= defined('BASE_URL') ? BASE_URL : '' ?>/carrito/agregar" class="form-add">
          <input type="hidden" name="producto_id" value="<?= $p->id ?>">
          <input
            type="number"
            name="cantidad"
            class="qty-input"
            value="1"
            min="1"
            max="<?= $disponible ?>"
            title="Cantidad"
          >
          <button type="submit" class="btn-add">Añadir</button>
        </form>
      <?php elseif ($disponible <= 0 && !$sinStock): ?>
        <span style="font-size:.75rem;color:var(--acento2);margin-left:auto;">Ya en carrito (máx)</span>
      <?php else: ?>
        <button class="btn-add" disabled style="margin-left:auto;">Agotado</button>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>
</div>
