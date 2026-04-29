<?php
namespace App\Storage;
use App\Models\Carrito;

class SessionCartStorage {
    public function save(Carrito $carrito) {
        $_SESSION['carrito_data'] = serialize($carrito);
    }

    public function load(): Carrito {
        if (isset($_SESSION['carrito_data'])) {
            return unserialize($_SESSION['carrito_data']);
        }
        return new Carrito();
    }
}