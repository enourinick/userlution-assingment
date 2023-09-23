<?php

namespace App\Services;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class GetPaginatedProductsWithCategoriesService {
    public function __invoke(bool $applyAgeRestriction = false): Builder {
        return Product::query()->when($applyAgeRestriction, function ($q) {
            $q->whereHas('category', function ($q) {
                $q->where('has_age_restriction', false);
            });
        })->with('category');
    }
}
