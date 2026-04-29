<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Controllers\CatalogController;
use App\Controllers\CartController;
use App\Core\Session;
use App\Models\ProductRepository;

$repository = new ProductRepository();
$session = new Session();

$catalogController = new CatalogController($repository, $session);
$cartController = new CartController($repository, $session);

$action = $_POST['action'] ?? $_GET['action'] ?? 'catalog';

switch ($action) {
    case 'add-to-cart':
        $cartController->add();
        break;

    case 'cart':
        $cartController->index();
        break;

    case 'catalog':
    default:
        $catalogController->index();
        break;
}