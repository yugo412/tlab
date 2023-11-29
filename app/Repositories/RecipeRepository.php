<?php

namespace App\Repositories;

use App\Models\Recipe;

interface RecipeRepository {
    public function paginate(?array $params = null);

    public function get(int $id): Recipe;

    public function store(array $params): ?Recipe;

    public function update(int $id, array $params): ?Recipe;

    public function delete(int $id): bool;
}
