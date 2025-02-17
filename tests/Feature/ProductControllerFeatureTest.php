<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the product index route returns products with final price calculated.
     *
     * @return void
     */
    public function testProductIndexReturnsCorrectDataWithFinalPrice()
    {
        // Arrange: Create a product with a 10% discount
        $product = Product::create([
            'title' => 'Smartphone',
            'description' => 'Latest smartphone',
            'price' => 500.00,
            'category' => 'electronics',
            'promotion_percentage' => 10, // 10% off
        ]);

        // Act: Send a GET request to the /api/products route
        $response = $this->getJson('/api/products');

        // Assert: Check if the response contains the product with the correct final_price
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'final_price' => 427.5, // 10% discount applied to the price (500 - 50 = 450)
            ]);
    }

    /**
     * Test if the final price is calculated correctly when getting a single product.
     *
     * @return void
     */
    public function testProductShowReturnsCorrectFinalPrice()
    {
        // Arrange: Create a product with a 15% discount
        $product = Product::create([
            'title' => 'Laptop',
            'description' => 'High performance laptop',
            'price' => 1000.00,
            'category' => 'electronics',
            'promotion_percentage' => 15, // 15% off
        ]);

        // Act: Send a GET request to the /api/products/{id} route
        $response = $this->getJson('/api/products/' . $product->id);

        // Assert: Check if the final price is correctly calculated and returned
        $response->assertStatus(200)
            ->assertJsonFragment([
                'final_price' => 855.00, // 15% discount applied to 1000 (1000 - 150 = 850)
            ]);
    }
}
