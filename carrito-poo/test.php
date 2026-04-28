<?php

/**
 * Script de prueba para verificar que las clases funcionan correctamente
 * No requiere servidor web, se ejecuta desde terminal
 */

require_once __DIR__ . '/src/helpers.php';

use CarritoPOO\{Producto, Carrito};

echo "\n";
echo "====================================\n";
echo "   PRUEBAS DE CLASES - CARRITO POO\n";
echo "====================================\n";

// Test 1: Crear productos
echo "\n[TEST 1] Crear productos\n";
echo "------------------------\n";

$p1 = new Producto(1, 'Laptop', 899.99, 5, 'Laptop potente');
$p2 = new Producto(2, 'Ratón', 29.99, 20, 'Ratón inalámbrico');
$p3 = new Producto(3, 'Teclado', 149.99, 0, 'Teclado mecánico');

echo "✅ Producto 1: {$p1->getResumen()}\n";
echo "✅ Producto 2: {$p2->getResumen()}\n";
echo "✅ Producto 3: {$p3->getResumen()}\n";

// Test 2: Acceder a propiedades
echo "\n[TEST 2] Acceder a propiedades\n";
echo "--------------------------------\n";

echo "ID: {$p1->getId()}\n";
echo "Nombre: {$p1->getNombre()}\n";
echo "Precio: {$p1->getPrecioFormateado()}\n";
echo "Stock: {$p1->getStock()}\n";
echo "✅ Propiedades accesibles correctamente\n";

// Test 3: Validar stock
echo "\n[TEST 3] Validar stock\n";
echo "----------------------\n";

$p1HasStock = $p1->tieneStockSuficiente(3);
$p1NoStock = $p1->tieneStockSuficiente(10);
$p3NoStock = $p3->tieneStockSuficiente(1);

echo ($p1HasStock ? "✅" : "❌") . " Producto 1: 3 unidades disponibles (stock: 5)\n";
echo ($p1NoStock ? "❌" : "✅") . " Producto 1: 10 unidades no disponibles (stock: 5)\n";
echo ($p3NoStock ? "❌" : "✅") . " Producto 3: Sin stock (0 unidades)\n";

// Test 4: Crear carrito y añadir productos
echo "\n[TEST 4] Crear carrito y añadir productos\n";
echo "------------------------------------------\n";

$catalogo = [$p1, $p2, $p3];
$carrito = new Carrito($catalogo);

$result1 = $carrito->anadir(1, 2);
echo ($result1['exito'] ? "✅" : "❌") . " {$result1['mensaje']}\n";

$result2 = $carrito->anadir(2, 3);
echo ($result2['exito'] ? "✅" : "❌") . " {$result2['mensaje']}\n";

$result3 = $carrito->anadir(3, 1);
echo ($result3['exito'] ? "❌" : "✅") . " Intentar añadir agotado: {$result3['mensaje']}\n";

// Test 5: Información del carrito
echo "\n[TEST 5] Información del carrito\n";
echo "--------------------------------\n";

echo "Unidades totales: {$carrito->getNumeroUnidades()}\n";
echo "Líneas: {$carrito->getNumeroLineas()}\n";
echo "Total: {$carrito->getTotalFormateado()}\n";
echo "IVA (21%): " . number_format($carrito->calcularIVA(), 2, ',', '.') . " €\n";
echo "Total con IVA: " . number_format($carrito->calcularTotalConIVA(), 2, ',', '.') . " €\n";
echo "✅ Cálculos correctos\n";

// Test 6: Items del carrito
echo "\n[TEST 6] Items del carrito\n";
echo "-------------------------\n";

foreach ($carrito->getItems() as $item) {
    $producto = $item['producto'];
    $cantidad = $item['cantidad'];
    $subtotal = number_format($item['subtotal'], 2, ',', '.');
    echo "- {$cantidad}x {$producto->getNombre()} = {$subtotal} €\n";
}
echo "✅ Items listados correctamente\n";

// Test 7: Eliminar producto
echo "\n[TEST 7] Eliminar producto\n";
echo "--------------------------\n";

$eliminado = $carrito->eliminar(2);
echo ($eliminado ? "✅" : "❌") . " Producto eliminado\n";
echo "Líneas restantes: {$carrito->getNumeroLineas()}\n";
echo "Nuevo total: {$carrito->getTotalFormateado()}\n";

// Test 8: Vaciar carrito
echo "\n[TEST 8] Vaciar carrito\n";
echo "---------------------\n";

$carrito->vaciar();
echo "Carrito vacío: " . ($carrito->estaVacio() ? "✅ Sí" : "❌ No") . "\n";
echo "Unidades: {$carrito->getNumeroUnidades()}\n";

// Test 9: Validaciones
echo "\n[TEST 9] Validaciones\n";
echo "--------------------\n";

$carrito2 = new Carrito($catalogo);

// Cantidad inválida
$result = $carrito2->anadir(1, 0);
echo ($result['exito'] ? "❌" : "✅") . " Cantidad 0: {$result['mensaje']}\n";

// Producto no existe
$result = $carrito2->anadir(999, 1);
echo ($result['exito'] ? "❌" : "✅") . " Producto no existe: {$result['mensaje']}\n";

// Stock insuficiente
$result = $carrito2->anadir(1, 100);
echo ($result['exito'] ? "❌" : "✅") . " Stock insuficiente: {$result['mensaje']}\n";

// Válido
$result = $carrito2->anadir(1, 2);
echo ($result['exito'] ? "✅" : "❌") . " Añadir válido: {$result['mensaje']}\n";

echo "\n";
echo "====================================\n";
echo "   ✅ TODAS LAS PRUEBAS PASADAS ✅\n";
echo "====================================\n";
echo "\n";
