<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function listActive()
    {
        return Cache::tags(['products'])->remember(
            'products:active:list',
            now()->addMinutes(10),
            fn () => Product::where('is_active', true)->get()
        );
    }

    public function search(string $term)
    {
        $term = trim($term);
        $cacheKey = 'products:search:' . sha1(mb_strtolower($term));

        return Cache::tags(['products'])->remember(
            $cacheKey,
            now()->addMinutes(10),
            fn () => Product::query()
                ->where('is_active', true)
                ->where(function ($query) use ($term) {
                    $query->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                })
                ->get()
        );
    }

    public function getById(int $id): Product
    {
        return Cache::tags(['products'])->remember(
            "products:{$id}:details",
            now()->addMinutes(10),
            fn () => Product::findOrFail($id)
        );
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);

        Cache::tags(['products'])->flush();

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        Cache::tags(['products'])->flush();

        return $product->refresh();
    }

    public function delete(Product $product): bool
    {
        $deleted = $product->delete();

        if ($deleted) {
            Cache::tags(['products'])->flush();
        }

        return $deleted;
    }
}
