<?php

namespace App\Services;
use App\Models\Product;

class GetProductWithCategoryService {
    public function __invoke(Product $product): Product {
        return $product->load('category');
    }
}
