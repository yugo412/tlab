<?php

namespace Tests\Feature\Api;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_get_recipe_and_paginate(): void
    {
        $recipe = Recipe::factory()->create();

        $this->get(route('recipe.index'))
            ->assertOk()
            ->assertJson([
                'current_page',
                'data' => [
                    '*' => $recipe->toArray(),
                ],
            ]);
    }

    /**
     * @return void
     */
    public function test_get_recipe_by_id(): void
    {
        $recipe = Recipe::factory()->create();

        $this->get(route('recipe.show', [$recipe]))
            ->assertOk()
            ->assertJson([
                'data' => [
                    '*' => $recipe->toArray(),
                ]
            ]);
    }

    public function test_store_recipe(): void
    {
        $recipe = Recipe::factory()->make();

        $this->post(route('recipe.store'), $recipe->toArray())
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    '*' => $recipe->toArray(),
                ],
            ]);
    }

    public function test_update_recipe_by_id()
    {
        $recipe = Recipe::factory()->create();

        $this->putJson(route('recipe.update', $recipe), ['name' => 'Kol'])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'name' => 'Kol',
                ],
            ]);
    }

    public function test_delete_recipe_by_id(): void
    {
        $recipe = Recipe::factory()->create();

        $this->deleteJson(route('recipe.destroy', $recipe))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
