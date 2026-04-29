
<?php

$producto = [
    'nombre' => 'Pack tienda online',
    'precio' => 49.95,
    'descuento' => 0.15,
    'stock' => 6,
    'envio_gratis' => true,
    'valoracion' => 4.6,
];


// Crea las siguientes funciones:

// - `calcular_precio_rebajado(float $precio, float $descuento): float`
function calcular_precio_rebajado(float $precio, float $descuento): float {
    
    return $precio - ($precio * $descuento);
}

// - `mostrar_badge_descuento(float $descuento): string`
function mostrar_badge_descuento(float $descuento): string {
    if ($descuento > 0) {
        return '<span>' . $descuento * 100 . "%" . '</span>';
    } else {
        return "";
    }
}

// - `mostrar_badge_envio(bool $envioGratis): string`
function mostrar_badge_envio(bool $envio_gratis): string {
    if ($envio_gratis === true) {
    return "Envio gratis";
    } else {
        return "";
    }
}

// - `formatear_valoracion(float $valoracion): string`
function formatear_valoracion(float $valoracion): string {
    return $valoracion . " / 5";
}

// - `renderizar_ficha_producto(array $producto): string`
function renderizar_ficha_producto(array $producto): string {
    $precio_rebajado = calcular_precio_rebajado($producto["precio"], $producto["descuento"]);
    $badge_descuento = mostrar_badge_descuento($producto["descuento"]);
    $badge_envio = mostrar_badge_envio($producto["envio_gratis"]);
    $valoracion = formatear_valoracion($producto["valoracion"]);
    return '
    <article>
    <h2>' . $producto["nombre"] . '</h2>
    <p>' . $producto["precio"] . '</p>
    <p>' . $precio_rebajado . '</p>
    <p>' . $badge_descuento . '</p>
    <p>' . $badge_envio . '</p>
    <p>' . $valoracion . '</p>
    </article>
    ';
}
echo renderizar_ficha_producto($producto);
// Condiciones:

// - `calcular_precio_rebajado()` debe devolver el precio final tras aplicar el descuento.
// - `mostrar_badge_descuento()` debe devolver un `<span>` con el porcentaje de descuento solo si el descuento es mayor que 0.
// - `mostrar_badge_envio()` debe devolver `Envío gratis` solo si corresponde.
// - `formatear_valoracion()` debe devolver un texto tipo `4.6 / 5`.
// - `renderizar_ficha_producto()` debe construir una ficha HTML completa usando el resto de funciones.
// - Muestra precio original y precio rebajado.

// Objetivo:

// - Componer funciones entre sí.
// - Ver cómo una función grande puede apoyarse en varias pequeñas.
// - Acercar el ejercicio a una ficha real de producto.

// ---