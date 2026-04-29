<?php

namespace App\Models;

/**
 * ProductoRepositorio — Fuente de datos de productos.
 *
 * Opción A (usada aquí): catálogo hardcodeado en objetos Producto.
 * Para cambiar a base de datos (Opción B) bastaría con reemplazar
 * el método getAll() por una consulta PDO sin tocar nada más.
 */
class ProductoRepositorio
{
    private static array $catalogo = [];

    /**
     * Devuelve todos los productos disponibles.
     *
     * @return Producto[]
     */
    public static function getAll(): array
    {
        if (!empty(self::$catalogo)) {
            return self::$catalogo;
        }

        self::$catalogo = [
            new Producto(1, 'Teclado Mecánico TKL',        89.99,  15, 'Switches Cherry MX Red, retroiluminación RGB, compacto sin numpad.',          'Periféricos',  'teclado.jpg'),
            new Producto(2, 'Ratón Inalámbrico Ergonómico', 49.50,  30, 'Sensor óptico 4000 DPI, batería de 60 h, receptor USB nano.',                  'Periféricos',  'raton.jpg'),
            new Producto(3, 'Monitor 27" IPS 144 Hz',      299.00,   8, 'Resolución QHD 2560×1440, tiempo de respuesta 1 ms, panel IPS antireflejos.',  'Monitores',    'monitor.jpg'),
            new Producto(4, 'Auriculares Gaming 7.1',       74.95,  20, 'Sonido envolvente virtual 7.1, micrófono retráctil con cancelación de ruido.',  'Audio',        'auriculares.jpg'),
            new Producto(5, 'Webcam HD 1080p',              59.00,  25, 'Autofoco rápido, micrófono estéreo integrado, compatible con OBS y Teams.',     'Periféricos',  'webcam.jpg'),
            new Producto(6, 'SSD NVMe 1 TB',               109.99,  12, 'Velocidades de lectura hasta 3500 MB/s, formato M.2 2280, PCIe Gen 3.',         'Almacenamiento','ssd.jpg'),
            new Producto(7, 'Hub USB-C 7 en 1',             35.00,  40, 'HDMI 4K, USB 3.0 ×3, SD/microSD, PD 100 W, compatible con Mac y PC.',          'Accesorios',   'hub.jpg'),
            new Producto(8, 'Alfombrilla XL Speed',         22.50,   3, 'Superficie de tela de alta velocidad, base antideslizante, 90×40 cm.',          'Accesorios',   'alfombrilla.jpg'),
        ];

        return self::$catalogo;
    }

    /**
     * Busca un producto por su ID. Devuelve null si no existe.
     */
    public static function getById(int $id): ?Producto
    {
        foreach (self::getAll() as $producto) {
            if ($producto->id === $id) {
                return $producto;
            }
        }
        return null;
    }
}
