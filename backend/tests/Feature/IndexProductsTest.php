<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndexProductsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_return_401_when_unauthenticated(): void
    {
        $response = $this->getJson('/product');

        $response->assertStatus(401);
    }

    public function test_receive_a_paginated_list_of_products(): void
    {
        $user = User::factory()->create();

        Category::factory()
            ->has(Product::factory()->count(20))
            ->count(2)
            ->create();

        $response = $this->actingAs($user)->getJson('/product');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'created_at',
                    'updated_at',
                    'name',
                    'image_url',
                    'category_id',
                    'category' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'name',
                        'has_age_restriction',
                    ],
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => [
                    'url',
                    'label',
                    'active',
                ],
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $response->assertJson([
            'current_page' => 1,
            'last_page' => 3,
            'from' => 1,
            'per_page' => 15,
            'to' => 15,
            'total' => 40,
        ]);
    }

    public function test_show_only_items_with_no_age_restriction_to_youth(): void
    {
        $user = User::factory()->underage()->create();

        $unrestrictedProductCount = 10;
        $unrestrictedCategory = Category::factory()
            ->has(Product::factory()->count($unrestrictedProductCount))
            ->unrestricted()
            ->create();

        $restrictedProductCount = 10;
        Category::factory()
            ->has(Product::factory()->count($restrictedProductCount))
            ->restricted()
            ->create();

        $response = $this->actingAs($user)->getJson('/product');

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has(
                'data',
                $unrestrictedProductCount,
                fn(AssertableJson $json) =>
                $json->where('id', $unrestrictedCategory->products()->first()->id)
                    ->etc()
            )->etc()
        );
    }

    public function test_show_all_items_to_adults(): void
    {
        $user = User::factory()->adult()->create();

        $unrestrictedProductCount = 5;
        Category::factory()
            ->has(Product::factory()->count($unrestrictedProductCount))
            ->unrestricted()
            ->create();

        $restrictedProductCount = 5;
        Category::factory()
            ->has(Product::factory()->count($restrictedProductCount))
            ->restricted()
            ->create();

        $response = $this->actingAs($user)->getJson('/product');

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has(
                'data',
                $unrestrictedProductCount + $restrictedProductCount,
            )->etc()
        );
    }
}