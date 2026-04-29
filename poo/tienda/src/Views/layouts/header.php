<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechShop — Tienda de Periféricos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --negro:    #0a0a0a;
      --blanco:   #f5f3ef;
      --acento:   #e84c1f;
      --acento2:  #f5a623;
      --gris1:    #1a1a1a;
      --gris2:    #2c2c2c;
      --gris3:    #888;
      --radio:    4px;
      --sombra:   0 4px 24px rgba(0,0,0,.45);
    }

    body {
      background: var(--negro);
      color: var(--blanco);
      font-family: 'DM Sans', sans-serif;
      font-weight: 300;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── NAV ── */
    nav {
      background: var(--gris1);
      border-bottom: 1px solid var(--gris2);
      padding: .9rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .nav-logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.4rem;
      color: var(--blanco);
      text-decoration: none;
      letter-spacing: -.5px;
    }

    .nav-logo span { color: var(--acento); }

    .nav-links { display: flex; gap: 1.5rem; align-items: center; }

    .nav-links a {
      color: var(--gris3);
      text-decoration: none;
      font-size: .9rem;
      font-weight: 400;
      transition: color .2s;
    }

    .nav-links a:hover, .nav-links a.activo { color: var(--blanco); }

    .nav-carrito {
      background: var(--acento);
      color: var(--blanco) !important;
      padding: .45rem 1rem;
      border-radius: var(--radio);
      font-weight: 500 !important;
      font-size: .85rem !important;
      transition: background .2s !important;
    }

    .nav-carrito:hover { background: #c93d15 !important; color: var(--blanco) !important; }

    /* ── FLASH ── */
    .flash {
      max-width: 1100px;
      margin: 1.2rem auto 0;
      padding: .85rem 1.2rem;
      border-radius: var(--radio);
      font-size: .9rem;
      font-weight: 400;
      border-left: 4px solid;
    }

    .flash.exito  { background: rgba(34,197,94,.12); border-color: #22c55e; color: #86efac; }
    .flash.error  { background: rgba(232,76,31,.12);  border-color: var(--acento); color: #fca5a5; }

    /* ── MAIN ── */
    main { flex: 1; max-width: 1100px; margin: 0 auto; padding: 2rem; width: 100%; }

    /* ── HEADING ── */
    h1.titulo-seccion {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      line-height: 1.1;
      margin-bottom: 2rem;
    }

    h1.titulo-seccion em {
      font-style: normal;
      color: var(--acento);
    }
  </style>
</head>
<body>

<?php $base = defined('BASE_URL') ? BASE_URL : ''; ?>
<nav>
  <a href="<?= $base ?>/" class="nav-logo">Tech<span>Shop</span></a>
  <div class="nav-links">
    <?php
      $rutaActual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $esInicio   = ($rutaActual === $base . '/' || $rutaActual === $base);
      $carritoNav = \App\Models\Carrito::cargarDesdeSesion();
      $unidades   = $carritoNav->getTotalUnidades();
    ?>
    <a href="<?= $base ?>/" <?= $esInicio ? 'class="activo"' : '' ?>>Catálogo</a>
    <a href="<?= $base ?>/carrito" class="nav-carrito">
      🛒 Carrito <?= $unidades > 0 ? "({$unidades})" : '' ?>
    </a>
  </div>
</nav>

<?php if (!empty($flash)): ?>
  <div class="flash <?= htmlspecialchars($flash['tipo']) ?>">
    <?= htmlspecialchars($flash['texto']) ?>
  </div>
<?php endif; ?>

<main>
