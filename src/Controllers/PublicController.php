<?php

declare(strict_types=1);

namespace SellNow\Controllers;

use SellNow\Core\Request;
use SellNow\Repositories\ProductRepository;
use SellNow\Repositories\UserRepository;
use Twig\Environment;

class PublicController
{

    public function __construct(
        private Environment $twig,
        private UserRepository $userRepo,
        private ProductRepository $productRepo
    ) {}

    /**
     * Get user profile
     */
    public function profile(Request $request, string $username): void
    {
        $user = $this->userRepo->findByUsername($username);

        if (empty($user)) {
            echo "User not found";
            return;
        }

        $products = $this->productRepo->getProductsByUserId($user->id());

        echo $this->twig->render('public/profile.html.twig', [
            'seller' => $user,
            'products' => $products
        ]);
    }
}
