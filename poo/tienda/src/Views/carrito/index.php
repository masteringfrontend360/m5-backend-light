<?php $base = defined('BASE_URL') ? BASE_URL : ''; ?>
<style>
  /* ── Layout carrito ── */
  .carrito-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 2rem;
    align-items: start;
  }

  @media (max-width: 768px) { .carrito-layout { grid-template-columns: 1fr; } }

  /* ── Tabla ── */
  .carrito-tabla {
    background: var(--gris1);
    border: 1px solid var(--gris2);
    border-radius: 8px;
    overflow: hidden;
  }

  .carrito-tabla table {
    width: 100%;
    border-collapse: collapse;
    font-size: .9rem;
  }

  .carrito-tabla thead {
    background: var(--gris2);
    font-family: 'Syne', sans-serif;
    font-size: .78rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--gris3);
  }

  .carrito-tabla th { padding: .85rem 1rem; text-align: left; }
  .carrito-tabla td { padding: .85rem 1rem; border-bottom: 1px solid var(--gris2); vertical-align: middle; }
  .carrito-tabla tbody tr:last-child td { border-bottom: none; }

  .item-nombre { font-weight: 500; }
  .item-precio { color: var(--gris3); font-size: .85rem; }
  .item-subtotal { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--acento2); }

  .btn-eliminar {
    background: transparent;
    border: 1px solid var(--gris2);
    border-radius: var(--radio);
    color: var(--gris3);
    padding: .3rem .65rem;
    font-size: .8rem;
    cursor: pointer;
    transition: border-color .2s, color .2s;
  }

  .btn-eliminar:hover { border-color: var(--acento); color: var(--acento); }

  /* ── Resumen ── */
  .carrito-resumen {
    background: var(--gris1);
    border: 1px solid var(--gris2);
    border-radius: 8px;
    padding: 1.5rem;
    position: sticky;
    top: 80px;
  }

  .resumen-titulo {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1.2rem;
    padding-bottom: .8rem;
    border-bottom: 1px solid var(--gris2);
  }

  .resumen-fila {
    display: flex;
    justify-content: space-between;
    font-size: .9rem;
    margin-bottom: .6rem;
    color: var(--gris3);
  }

  .resumen-fila strong { color: var(--blanco); }

  .resumen-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.2rem;
    padding-top: 1.2rem;
    border-top: 1px solid var(--gris2);
  }

  .resumen-total-label {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 1rem;
  }

  .resumen-total-precio {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 1.6rem;
    color: var(--acento2);
  }

  .btn-vaciar {
    display: block;
    width: 100%;
    margin-top: 1.2rem;
    background: transparent;
    border: 1px solid var(--gris2);
    border-radius: var(--radio);
    color: var(--gris3);
    padding: .6rem;
    font-size: .85rem;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: border-color .2s, color .2s;
  }

  .btn-vaciar:hover { border-color: var(--acento); color: var(--acento); }

  .btn-seguir {
    display: block;
    text-align: center;
    margin-top: .8rem;
    background: var(--acento);
    color: var(--blanco);
    text-decoration: none;
    border-radius: var(--radio);
    padding: .7rem;
    font-weight: 500;
    font-size: .9rem;
    transition: background .2s;
  }

  .btn-seguir:hover { background: #c93d15; }

  /* ── Vacío ── */
  .carrito-vacio {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--gris1);
    border: 1px solid var(--gris2);
    border-radius: 8px;
    grid-column: 1 / -1;
  }

  .carrito-vacio .emoji { font-size: 3.5rem; display: block; margin-bottom: 1rem; }
  .carrito-vacio p { color: var(--gris3); margin-bottom: 1.5rem; }
  .carrito-vacio a {
    background: var(--acento);
    color: var(--blanco);
    text-decoration: none;
    border-radius: var(--radio);
    padding: .7rem 1.5rem;
    font-weight: 500;
    transition: background .2s;
    display: inline-block;
  }
  .carrito-vacio a:hover { background: #c93d15; }
</style>

<h1 class="titulo-seccion">Tu <em>carrito</em></h1>

<div class="carrito-layout">

<?php if ($carrito->estaVacio()): ?>
  <div class="carrito-vacio">
    <span class="emoji">🛒</span>
    <p>Tu carrito está vacío. ¡Echa un vistazo al catálogo!</p>
    <a href="<?= $base ?>/">Ir al catálogo</a>
  </div>

<?php else: ?>

  <!-- Tabla de items -->
  <div class="carrito-tabla">
    <table>
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio u.</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($carrito->getItems() as $id => $item):
          $p = $item['producto'];
          $qty = $item['cantidad'];
          $subtotal = number_format($p->getPrecio() * $qty, 2, ',', '.') . ' €';
        ?>
        <tr>
          <td>
            <div class="item-nombre"><?= htmlspecialchars($p->nombre) ?></div>
          </td>
          <td class="item-precio"><?= $p->getPrecioFormateado() ?></td>
          <td><?= $qty ?></td>
          <td class="item-subtotal"><?= $subtotal ?></td>
          <td>
            <form method="POST" action="<?= $base ?>/carrito/eliminar">
              <input type="hidden" name="producto_id" value="<?= $p->id ?>">
              <button type="submit" class="btn-eliminar" title="Eliminar">✕</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Resumen lateral -->
  <aside class="carrito-resumen">
    <div class="resumen-titulo">Resumen del pedido</div>
    <div class="resumen-fila">
      <span>Artículos</span>
      <strong><?= $carrito->getTotalUnidades() ?> uds.</strong>
    </div>
    <div class="resumen-fila">
      <span>Envío</span>
      <strong>Gratis</strong>
    </div>
    <div class="resumen-total">
      <span class="resumen-total-label">Total</span>
      <span class="resumen-total-precio"><?= $carrito->getTotalFormateado() ?></span>
    </div>

    <a href="<?= $base ?>/" class="btn-seguir">← Seguir comprando</a>

    <form method="POST" action="<?= $base ?>/carrito/vaciar">
      <button type="submit" class="btn-vaciar">Vaciar carrito</button>
    </form>
  </aside>

<?php endif; ?>

</div>
