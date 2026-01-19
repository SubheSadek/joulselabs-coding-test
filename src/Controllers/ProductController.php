<?php

namespace SellNow\Controllers;

use SellNow\Core\Request;
use SellNow\Repositories\ProductRepository;
use SellNow\Repositories\UserRepository;
use SellNow\Services\ProductService;
use Twig\Environment;

class ProductController
{

    public function __construct(
        private Environment $twig,
        private ProductService $productService,
        protected UserRepository $userRepo,
        protected ProductRepository $productRepo
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

    /**
     * Show user products.
     */
    public function show(Request $request, string $username): void
    {
        $requestData = $this->productService->formatPaginationData($request);

        $result = $this->productService->validatePaginationRequest($requestData);

        if ($result->fails()) {
            die("Invalid pagination data");
        }

        $user = $this->userRepo->findByUsername($username);

        if (empty($user)) {
            die("User not found");
        }

        $products = $this->productRepo->getProductsByUserId(
            $user->id(),
            $requestData['limit'],
            $requestData['offset']
        );

        $total = $this->productRepo->countByUserId($user->id());
        $hasMore = ($requestData['offset'] + $requestData['limit']) < $total;

        if ($request->input('ajax') === '1') {
            echo $this->twig->render('public/_products.html.twig', [
                'products' => $products
            ]);
            return;
        }

        echo $this->twig->render('public/profile.html.twig', [
            'seller'       => $user,
            'products'     => $products,
            'currentPage'  => $requestData['page'],
            'limit'        => $requestData['limit'],
            'hasMore'      => $hasMore,
        ]);
    }

}
