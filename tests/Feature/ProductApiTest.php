<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // ProductService uses Redis cache tags, including during feature tests.
        config(['cache.default' => 'redis']);
        Cache::tags(['products'])->flush();
    }

    protected function tearDown(): void
    {
        Cache::tags(['products'])->flush();

        parent::tearDown();
    }

    public function test_index_returns_only_active_products_and_uses_cache(): void
    {
        $this->product(['name' => 'Active item', 'is_active' => true]);
        $this->product(['name' => 'Inactive item', 'is_active' => false]);

        Event::fake([CacheHit::class, CacheMissed::class]);

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Active item');

        $this->assertTrue(Cache::tags(['products'])->has('products:active:list'));

        $this->getJson('/api/products')->assertOk();

        Event::assertDispatched(CacheMissed::class);
        Event::assertDispatched(CacheHit::class);
    }

    public function test_search_returns_matching_active_products_and_requires_a_query(): void
    {
        $this->product(['name' => 'Blue phone', 'is_active' => true]);
        $this->product(['name' => 'Blue phone inactive', 'is_active' => false]);

        $this->getJson('/api/products/search?q=phone')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Blue phone');

        $this->getJson('/api/products/search')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_store_validates_creates_product_and_invalidates_cached_list_and_search(): void
    {
        $this->getJson('/api/products')->assertOk();
        $this->getJson('/api/products/search?q=phone')->assertOk();

        $this->postJson('/api/products', [
            'name' => 'New phone',
            'description' => 'A new product',
            'price' => 299.99,
            'stock' => 5,
            'is_active' => true,
        ])->assertCreated()
            ->assertJsonPath('data.name', 'New phone');

        $this->assertFalse(Cache::tags(['products'])->has('products:active:list'));

        $this->getJson('/api/products/search?q=phone')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->postJson('/api/products', ['price' => -1])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'price']);
    }

    public function test_show_and_update_return_product_and_update_invalidates_cached_results(): void
    {
        $product = $this->product(['name' => 'Old name']);

        $this->getJson("/api/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('data.name', 'Old name');
        $this->getJson('/api/products')->assertOk();
        $this->getJson('/api/products/search?q=old')->assertOk();

        $this->putJson("/api/products/{$product->id}", ['name' => 'New name'])
            ->assertOk()
            ->assertJsonPath('data.name', 'New name');

        $this->assertFalse(Cache::tags(['products'])->has("products:{$product->id}:details"));
        $this->assertFalse(Cache::tags(['products'])->has('products:active:list'));

        $this->getJson('/api/products/search?q=new')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'New name');
    }

    public function test_destroy_returns_json_and_invalidates_cached_product_data(): void
    {
        $product = $this->product(['name' => 'To delete']);

        $this->getJson('/api/products')->assertOk();
        $this->getJson("/api/products/{$product->id}")->assertOk();

        $this->deleteJson("/api/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Product deleted successfully.');

        $this->assertFalse(Cache::tags(['products'])->has('products:active:list'));
        $this->getJson('/api/products')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson("/api/products/{$product->id}")->assertNotFound();
    }

    private function product(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Example product',
            'description' => 'An example product description',
            'price' => 10.00,
            'stock' => 2,
            'is_active' => true,
        ], $overrides));
    }
}
