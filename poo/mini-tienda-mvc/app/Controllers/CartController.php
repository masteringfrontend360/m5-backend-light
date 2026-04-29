<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\Cart;
use App\Models\ProductRepository;

class CartController
{
    public function __construct(
        private ProductRepository $repository,
        private Session $session
    ) {
    }

    public function add(): void
    {
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if (!$productId) {
            $this->session->flash('error', 'El producto enviado no es válido.');
            header('Location: index.php');
            exit;
        }

        if (!$quantity) {
            $this->session->flash('error', 'La cantidad enviada no es válida.');
            header('Location: index.php');
            exit;
        }

        $product = $this->repository->findById($productId);

        if (!$product) {
            $this->session->flash('error', 'El producto no existe.');
            header('Location: index.php');
            exit;
        }

        $cart = new Cart($this->session);
        $result = $cart->add($product, $quantity);

        if ($result['success']) {
            $this->session->flash('success', $result['message']);
        } else {
            $this->session->flash('error', $result['message']);
        }

        header('Location: index.php');
        exit;
    }

    public function index(): void
    {
        $cart = new Cart($this->session);

        View::render('cart', [
            'items' => $cart->all(),
            'total' => $cart->getTotal(),
            'cartItemsCount' => $cart->getTotalItems(),
            'successMessage' => $this->session->flash('success'),
            'errorMessage' => $this->session->flash('error'),
        ]);
    }
}