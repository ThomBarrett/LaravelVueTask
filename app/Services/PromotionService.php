<?php

namespace App\Services;

use App\Models\Product;

class PromotionService
{
    /**
     * Calculate the final price for a product after applying all promotions.
     *
     * @param Product $product
     * @return float
     */
    public function calculateFinalPrice(Product $product): float
    {
        $price = $product->price;

        // Apply category-based discount (e.g., 5% for electronics)
        $price = $this->applyCategoryDiscount($product, $price);

        // Apply special customer discount (e.g., 10%)
        $price = $this->applyCustomerDiscount($price);

        // Apply any additional promotion percentage if available
        $price = $this->applyPromotionPercentage($product, $price);

        return round($price, 2); // Return final price rounded to 2 decimal places
    }

    /**
     * Apply a discount based on the product category.
     *
     * @param Product $product
     * @param float $price
     * @return float
     */
    private function applyCategoryDiscount(Product $product, float $price): float
    {
        // Example: Apply 5% discount for electronics category
        if ($product->category == 'electronics') {
            $price -= $price * 0.05; // Apply 5% discount for electronics
        }

        return $price;
    }

    /**
     * Apply a discount for special customers.
     *
     * @param float $price
     * @return float
     */
    private function applyCustomerDiscount(float $price): float
    {
        // Example logic: If the customer is special, apply a 10% discount
        if ($this->isSpecialCustomer()) {
            $price -= $price * 0.10; // Apply 10% discount for special customers
        }

        return $price;
    }

    /**
     * Check if the customer qualifies for special discounts.
     *
     * @return bool
     */
    private function isSpecialCustomer(): bool
    {
        // For now, assume that all customers are special
        return true; // You can integrate actual logic here (e.g., check logged-in user role or group)
    }

    /**
     * Apply any additional promotion percentage from the product.
     *
     * @param Product $product
     * @param float $price
     * @return float
     */
    private function applyPromotionPercentage(Product $product, float $price): float
    {
        // If there is a promotion percentage set, apply it
        if ($product->promotion_percentage) {
            $price -= $price * ($product->promotion_percentage / 100);
        }

        return $price;
    }
}
