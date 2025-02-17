<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\PromotionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    // Set up the PromotionService mock to avoid using the real service
    protected $promotionService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the PromotionService to control the behavior
        $this->promotionService = $this->createMock(PromotionService::class);
    }

    /**
     * Test if the ProductController returns the correct product data with final price.
     *
     * @return void
     */
    public function testProductIndexReturnsCorrectData()
    {
        // Arrange: Create a product in the database
        $product = Product::create([
            'title' => 'Smartphone',
            'description' => 'Latest smartphone',
            'price' => 499.99,
            'category' => 'electronics',
            'promotion_percentage' => 10 // 10% off
        ]);

        // Mock the PromotionService to return the final price
        $this->promotionService
            ->method('calculateFinalPrice')
            ->willReturn(449.99); // Mocked final price after applying promotion

        // Bind the mock service to the container (this is important for controller usage)
        $this->app->instance(PromotionService::class, $this->promotionService);

        // Act: Make a GET request to the API endpoint for products
        $response = $this->getJson('/api/products');

        // Assert: The response status is 200 (OK) and contains the final_price
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'final_price' => 449.99, // Make sure final price is returned correctly
            ]);
    }

    /**
     * Test if the final price is correctly calculated when promotion is applied
     *
     * @return void
     */
    public function testProductFinalPriceCalculation()
    {
        // Arrange: Create a product
        $product = Product::create([
            'title' => 'Laptop',
            'description' => 'High performance laptop',
            'price' => 1000.00,
            'category' => 'electronics',
            'promotion_percentage' => 15 // 15% off
        ]);

        // Mock the PromotionService to return the final price
        $this->promotionService
            ->method('calculateFinalPrice')
            ->willReturn(850.00); // Mocked final price after applying promotion

        // Bind the mock service to the container
        $this->app->instance(PromotionService::class, $this->promotionService);

        // Act: Call the API endpoint to get the product
        $response = $this->getJson('/api/products/' . $product->id);

        // Assert: Check if the final_price is correctly calculated
        $response->assertStatus(200)
            ->assertJsonFragment([
                'final_price' => 850.00, // The final price should be 850.00 after applying 15% discount
            ]);
    }
}
