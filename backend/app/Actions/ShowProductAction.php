<?php

namespace App\Actions;

use App\Models\Product;
use App\Services\GetProductWithCategoryService;


class ShowProductAction {
    public function __construct(private GetProductWithCategoryService $getProductWithCategoryService) {}

    public function __invoke(Product $product): Product {
        return ($this->getProductWithCategoryService)($product);
    }
}