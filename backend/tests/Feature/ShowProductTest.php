<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowProductTest extends TestCase
{
    use DatabaseTransactions;

    public function test_return_401_when_unauthenticated(): void
    {
        $category = Category::factory()
            ->has(Product::factory())
            ->create();

        $response = $this->getJson('/product/' . $category->products[0]->id);

        $response->assertStatus(401);
    }

    public function test_return_404_when_product_is_not_found(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/product/' . 1000);

        $response->assertStatus(404);
    }

    public function test_receive_a_product(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()
            ->has(Product::factory())
            ->create();

        $product = $category->products[0];

        $response = $this->actingAs($user)->getJson('/product/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            "id" => $product->id,
            "name" => $product->name,
            "image_url" => $product->image_url,
            "price" => $product->price,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "category" => [
                "id" => $category->id,
                "name" => $category->name,
                "has_age_restriction" => $category->has_age_restriction,
            ]
        ]);
    }

    public function test_return_403_when_an_underaged_user_attempts_to_access_a_restricted_product(): void
    {
        $user = User::factory()->underage()->create();
        $category = Category::factory()
            ->has(Product::factory())
            ->restricted()
            ->create();
        $product = $category->products[0];

        $response = $this->actingAs($user)->getJson('/product/' . $product->id);

        $response->assertStatus(403);
    }

    public function test_return_the_product_when_an_underaged_user_attempts_to_access_an_unrestricted_product(): void
    {
        $user = User::factory()->underage()->create();
        $category = Category::factory()
            ->has(Product::factory())
            ->unrestricted()
            ->create();
        $product = $category->products[0];

        $response = $this->actingAs($user)->getJson('/product/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            "id" => $product->id,
            "name" => $product->name,
            "image_url" => $product->image_url,
            "price" => $product->price,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "category" => [
                "id" => $category->id,
                "name" => $category->name,
                "has_age_restriction" => $category->has_age_restriction,
            ]
        ]);
    }

    public function test_return_the_product_when_an_adult_attempts_to_access_a_restricted_product(): void
    {
        $user = User::factory()->adult()->create();
        $category = Category::factory()
            ->has(Product::factory())
            ->restricted()
            ->create();
        $product = $category->products[0];

        $response = $this->actingAs($user)->getJson('/product/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            "id" => $product->id,
            "name" => $product->name,
            "image_url" => $product->image_url,
            "price" => $product->price,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "category" => [
                "id" => $category->id,
                "name" => $category->name,
                "has_age_restriction" => $category->has_age_restriction,
            ]
        ]);
    }

    public function test_return_the_product_when_an_adult_user_attempts_to_access_an_unrestricted_product(): void
    {
        $user = User::factory()->adult()->create();
        $category = Category::factory()
            ->has(Product::factory())
            ->unrestricted()
            ->create();
        $product = $category->products[0];

        $response = $this->actingAs($user)->getJson('/product/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            "id" => $product->id,
            "name" => $product->name,
            "image_url" => $product->image_url,
            "price" => $product->price,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "category" => [
                "id" => $category->id,
                "name" => $category->name,
                "has_age_restriction" => $category->has_age_restriction,
            ]
        ]);
    }
}