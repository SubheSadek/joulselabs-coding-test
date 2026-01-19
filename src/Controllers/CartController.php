<?php

declare(strict_types=1);

namespace SellNow\Controllers;

use SellNow\Core\Request;
use SellNow\Repositories\ProductRepository;
use SellNow\Services\CartService;
use Twig\Environment;

class CartController
{
    public function __construct(
        private CartService $cartService,
        private ProductRepository $productRepo,
        private Environment $twig
    ) {}

    /**
     * Show the cart.
     */
    public function index(Request $request): void
    {
        $formattedCart = $this->cartService->formatCart();
        echo $this->twig->render('cart/index.html.twig', $formattedCart);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request): void
    {
        $data = [
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
        ];

        $result = $this->cartService->validateAddToCartRequest($data);

        if ($result->fails()) {
            header('Content-Type: application/json');
            http_response_code(422);
            echo json_encode(['status' => 'error', 'errors' => $result->errors()]);
            exit;
        }

        $product = $this->productRepo->getSingleProductById((int)$data['product_id']);

        if (empty($product)) {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
            exit;
        }

        $_SESSION['cart'][] = [
            'product_id' => $product->id(),
            'title' => $product->title(),
            'price' => $product->price(),
            'quantity' => $data['quantity']
        ];

        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['status' => 'success', 'count' => count($_SESSION['cart'])]);
        exit;
    }

    /**
     * Clear the cart.
     */
    public function clear(Request $request): void
    {
        unset($_SESSION['cart']);
        unset($_SESSION['provider']);
        header("Location: /cart");
        exit;
    }
}
