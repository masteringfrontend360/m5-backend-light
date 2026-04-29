<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\Cart;
use App\Models\ProductRepository;

class CatalogController
{
    public function __construct(
        private ProductRepository $repository,
        private Session $session
    ) {
    }

    public function index(): void
    {
        $products = $this->repository->all();
        $cart = new Cart($this->session);

        View::render('catalog', [
            'products' => $products,
            'cartItemsCount' => $cart->getTotalItems(),
            'successMessage' => $this->session->flash('success'),
            'errorMessage' => $this->session->flash('error'),
        ]);
    }
}