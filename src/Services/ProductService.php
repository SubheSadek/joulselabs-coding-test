<?php

declare(strict_types=1);

namespace SellNow\Services;

use SellNow\Core\Request;
use SellNow\Core\Validation\ValidationResult;
use SellNow\Core\Validation\Validator;
use SellNow\Domain\Product;
use SellNow\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private FileUploaderService $fileUploader,
        private ProductRepository $productRepo
    ) {}
    
    /**
     * Validate store product request.
     */
    public function validateStoreProductRequest(array $data): ValidationResult
    {
        $validator = new Validator();

        return $validator->validate($data, [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'product_file' => 'required|file|mimes:pdf,doc,docx,zip|max:2048'
        ]);
    }

    /**
     * Store product.
     * 
     * @param Request $request
     * @param array $data
     * @return Product
     */
    public function storeProduct(Request $request, array $data): Product
    {
        $data = $this->formatRequestData($request, $data);

        $product = $this->productRepo->create(
            $data['title'],
            $data['slug'],
            (float) $data['price'],
            imagePath: $data['image_path'],
            filePath: $data['file_path']
        );

        return $product;
    }

    /**
     * Format request data.
     */
    private function formatRequestData(Request $request, array $data): array
    {
        $data['file_path'] = null;
        $data['image_path'] = null;

        if ($request->hasFile('product_file')) {
            $data['file_path'] = $this->fileUploader->upload($request->file('product_file'), 'dl');
        }

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->fileUploader->upload($request->file('image'), 'img');
        }

        $data['slug'] = strtolower(str_replace(' ', '-', $request->input('title'))) . '-' . rand(1000, 9999);

        return $data;
    }

    /**
     * Format pagination data.
     */
    public function formatPaginationData(Request $request): array
    {
        $page = max(1, (int) ($request->input('page') ?? 1));
        $limit = $request->input('limit') ?? 20;
        $offset = ($page - 1) * $limit;

        return [
            'page' => $page,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

    /**
     * Validate pagination request.
     */
    public function validatePaginationRequest(array $data): ValidationResult
    {
        $validator = new Validator();

        return $validator->validate($data, [
            'page' => 'required|integer|min:1',
            'limit' => 'required|integer|min:1|max:100',
        ]);
    }
}