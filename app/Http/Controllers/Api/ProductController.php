<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $products
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->products->listActive(),
        ], 200);
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'max:100'],
        ]);

        return response()->json([
            'data' => $this->products->search($validated['q']),
        ], 200);
    }

    public function show(int $product): JsonResponse
    {
        return response()->json([
            'data' => $this->products->getById($product),
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $product = $this->products->create($validated);

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request, int $product): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $existingProduct = $this->products->getById($product);
        $updatedProduct = $this->products->update($existingProduct, $validated);

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => $updatedProduct,
        ], 200);
    }

    public function destroy(int $product): JsonResponse
    {
        $existingProduct = $this->products->getById($product);
        $this->products->delete($existingProduct);

        return response()->json([
            'message' => 'Product deleted successfully.',
        ], 200);
    }
}
