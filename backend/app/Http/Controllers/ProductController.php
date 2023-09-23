<?php

namespace App\Http\Controllers;

use App\Actions\IndexProductsAction;
use App\Actions\ShowProductAction;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(
        private IndexProductsAction $indexProductsAction,
        private ShowProductAction $showProductAction,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ($this->indexProductsAction)($request->user());
    }
    
    public function show(Product $product)
    {
        $this->authorize('view', [$product]);

        return ($this->showProductAction)($product);
    }
}
