<?php
namespace App\Repositories;
use App\Models\Producto;
use PDO;

class ProductoRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findById(int $id): ?Producto {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Producto($row['id'], $row['nombre'], $row['precio'], $row['stock']) : null;
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM productos");
        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = new Producto($row['id'], $row['nombre'], $row['precio'], $row['stock']);
        }
        return $productos;
    }
}