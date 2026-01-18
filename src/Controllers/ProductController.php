<?php

namespace SellNow\Controllers;

use SellNow\Core\Request;
use SellNow\Services\FileUploaderService;
use SellNow\Services\ProductService;
use Twig\Environment;

class ProductController
{

    public function __construct(
        private Environment $twig,
        private ProductService $productService
    ) {}

    /**
     * Get create product form.
     */
    public function create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        echo $this->twig->render('products/add.html.twig');
    }

    /**
     * Store product.
     */
    public function store(Request $request): void
    {
        if (!isset($_SESSION['user_id'])) {
            die("Unauthorized");
        }

        $data = [
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'image' => $request->file('image'),
            'product_file' => $request->file('product_file')
        ];

        $result = $this->productService->validateStoreProductRequest($data);

        if ($result->fails()) {
            echo $this->twig->render('products/add.html.twig', [
                'errors' => $result->errors(),
                'old' => $data,
            ]);

            exit;
        }

        $product = $this->productService->storeProduct($request, $data);

        header("Location: /dashboard");
        exit;
    }
}
