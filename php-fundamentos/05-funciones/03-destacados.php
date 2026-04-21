
<?php

$productos = [
    ['nombre' => 'Plugin SEO', 'precio' => 29.99, 'destacado' => true, 'stock' => 12],
    ['nombre' => 'Tema corporativo', 'precio' => 59.00, 'destacado' => false, 'stock' => 4],
    ['nombre' => 'Pack formularios', 'precio' => 18.50, 'destacado' => true, 'stock' => 0],
    ['nombre' => 'Módulo reservas', 'precio' => 80.00, 'destacado' => true, 'stock' => 7],
];


// Crea las siguientes funciones:

// - `es_producto_visible(array $producto): bool`
function es_producto_visible(array $producto): bool {
    return $producto["destacado"] === true;
}

// - `generar_etiqueta_stock(int $stock): string`
function generar_etiqueta_stock(int $stock): string {
    if ($stock === 0) {
    return "Agotado";
    } else if ($stock <= 5) {
    return "Ultimas unidades";
    } else {
        return "Disponible";
    }
}

// - `renderizar_tarjeta_destacada(array $producto): string`
function renderizar_tarjeta_destacada(array $producto): string {
    $etiqueta_stock = generar_etiqueta_stock($producto["stock"]);
    return '
    <article>
    <h2>' . $producto["nombre"] . '</h2>
    <p>' . $producto["precio"] . '</p>
    <p>' . $etiqueta_stock . '</p>
    </article>
';
}

// - `renderizar_listado_destacados(array $productos): string`
function renderizar_listado_destacados(array $productos): string {
    $salida = "";

    foreach ($productos as $producto) {
        if (es_producto_visible($producto)) {
            $salida .= renderizar_tarjeta_destacada($producto);
        }
    }
    return $salida;
}
echo renderizar_listado_destacados($productos);
// Condiciones:

// - Solo deben mostrarse productos marcados como destacados.
// - `es_producto_visible()` debe decidir si el producto se pinta o no.
// - `generar_etiqueta_stock()` debe devolver una etiqueta breve:
//     - `Disponible`
//     - `Últimas unidades`
//     - `Agotado`
// - `renderizar_tarjeta_destacada()` debe devolver una tarjeta HTML por producto.
// - `renderizar_listado_destacados()` debe recorrer todos los productos y devolver el bloque completo.

// Objetivo:

// - Trabajar funciones que reciben arrays.
// - Separar filtrado, transformación y render.
// - Simular un bloque de destacados para home o archivo de tienda.

// ---