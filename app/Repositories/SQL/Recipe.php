<?php

namespace App\Repositories\SQL;

use App\Repositories\RecipeRepository;
use App\Models\Recipe as Model;
use Illuminate\Support\Facades\DB;

class Recipe implements RecipeRepository
{
    public function paginate(?array $params = null)
    {
        return Model::with('ingredients', 'cooks')->paginate(data_get($params, 'limit', 20));
    }

    public function get(int $id): Model
    {
        return Model::whereId($id)
            ->with('ingredients', 'cooks')
            ->firstOrFail();
    }

    /**
     * @param array $params
     * @return Model|null
     */
    public function store(array $params): ?Model
    {
        return DB::transaction(static function () use ($params) {
            $recipe = Model::create($params);
            foreach ($params['ingredients'] as $ingredient) {
                $recipe->ingredients()->create([
                    'name' => $ingredient,
                    'description' => '',
                ]);
            }

            foreach ($params['cooks'] as $cook) {
                $recipe->cooks()->create(['instruction' => $cook]);
            }

            $recipe->load('ingredients', 'cooks');

            return $recipe;
        });
    }

    /**
     * @param int $id
     * @param array $params
     * @return Model|null
     */
    public function update(int $id, array $params): ?Model
    {
        DB::transaction(static function() use($id, $params){
            $recipe = Model::findOrFirst($id);
            foreach ($params['ingredients'] as $ingredient) {
                $recipe->ingredients()->create([
                    'name' => $ingredient,
                    'description' => '',
                ]);
            }

            foreach ($params['cooks'] as $cook) {
                $recipe->cooks()->create(['instruction' => $cook]);
            }


            return $recipe;
        });

        return null;
    }

    public function delete(int $id): bool
    {
        return Model::find($id)->delete();
    }
}
