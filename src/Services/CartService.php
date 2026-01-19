<?php

declare(strict_types=1);

namespace SellNow\Services;

use SellNow\Core\Validation\ValidationResult;
use SellNow\Core\Validation\Validator;
use SellNow\Repositories\ProductRepository;


class CartService
{
    public function __construct(
        private ProductRepository $productRepo
    ) {}

    /**
     * Validate add to cart request.
     */
    public function validateAddToCartRequest(array $data): ValidationResult
    {
        $validator = new Validator();

        return $validator->validate($data, [
            'product_id' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
        ]);
    }

    /**
     * Format cart.
     */
    public function formatCart(): array
    {
        $cart = $_SESSION['cart'] ?? [];

        return [
            'cart' => $cart,
            'total' => $this->getCartTotal($cart)
        ];
    }

    /**
     * Get cart total.
     */
    public function getCartTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}