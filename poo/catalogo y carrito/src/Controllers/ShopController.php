<?php
namespace App\Controllers;

use App\Models\Carrito;
use App\Models\Producto;

class ShopController {
    public function __construct(
        private Carrito $carrito,
        private array $catalogo // En un sistema real, esto vendría de un Repositorio
    ) {}

    public function index(): void {
        $message = '';
        
        // Procesar POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = (int)$_POST['id'];
                $qty = (int)$_POST['cantidad'];
                $this->carrito->add($this->catalogo[$id], $qty);
                $message = "Producto añadido.";
            } catch (\Exception $e) {
                $message = "Error: " . $e->getMessage();
            }
        }

        // Datos para la vista
        $items = $this->carrito->getItems();
        $total = $this->carrito->calcularTotal($this->catalogo);
        $catalogo = $this->catalogo;

        // "Renderizar" la vista
        require __DIR__ . '/../Views/catalogo.php';
    }
}