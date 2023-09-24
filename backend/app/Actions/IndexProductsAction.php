<?php

namespace App\Actions;

use App\Models\User;
use App\Services\GetPaginatedProductsWithCategoriesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class IndexProductsAction {
    public function __construct(private GetPaginatedProductsWithCategoriesService $getPaginatedProductsWithCategoriesService) {}

    public function __invoke(User $user): LengthAwarePaginator {
        $eighteenYearsAgo = Carbon::now()->subYears(18);
        $thirtyoneYearsAgo = Carbon::now()->subYears(31);

        return ($this->getPaginatedProductsWithCategoriesService)(
                $eighteenYearsAgo->lt($user->date_of_birth) || $thirtyoneYearsAgo->gt($user->date_of_birth)
            )->paginate();
    }
}