<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\PromotionService;

class ProductController extends Controller
{
    // Declare the PromotionService as a protected property
    protected $promotionService;

    /**
     * Inject the PromotionService into the controller
     *
     * @param PromotionService $promotionService
     */
    public function __construct(PromotionService $promotionService)
    {
        // Assign the injected service to the protected property
        $this->promotionService = $promotionService;
    }

    /**
     * Get all products with their final price after applying promotions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch products with pagination (10 products per page)
        $products = Product::paginate(10); // You can adjust the number to fit your needs

        // Calculate the final price for each product
        foreach ($products as $product) {
            $product->final_price = $this->promotionService->calculateFinalPrice($product);
        }

        return response()->json($products); // Return the paginated products as JSON
    }

    /**
     * Get a single product with its final price after applying promotions
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Calculate the final price using the PromotionService
        $product->final_price = $this->promotionService->calculateFinalPrice($product);

        // Return the product with the final price
        return response()->json($product);
    }

    /**
     * Create a new product
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'promotion_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Create a new product from the validated data
        $product = Product::create($validated);

        // Return the newly created product with the final price
        $product->final_price = $this->promotionService->calculateFinalPrice($product);

        return response()->json($product, 201);
    }

    /**
     * Update a product
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'promotion_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update the product with the validated data
        $product->update($validated);

        // Calculate the final price after applying promotions
        $product->final_price = $this->promotionService->calculateFinalPrice($product);

        // Return the updated product with the final price
        return response()->json($product);
    }

    /**
     * Delete a product
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Return a success message
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
