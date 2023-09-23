<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

class ProductPolicy
{
    public function view(User $user, Product $product): bool
    {
        return !$product->category->has_age_restriction || Carbon::now()->subYears(18)->gt($user->date_of_birth);
    }
}
