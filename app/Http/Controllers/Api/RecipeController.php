<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recipe\StoreRequest;
use App\Http\Requests\Recipe\UpdateRequest;
use App\Repositories\RecipeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PHPUnit\Runner\Exception;

class RecipeController extends Controller
{
    public function __construct(private readonly RecipeRepository $recipe)
    {
    }

    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function index(StoreRequest $request): JsonResponse
    {
        return response()->json($this->recipe->paginate($request->all()));
    }

    /**
     * @param RecipeRepository $recipe
     * @param int $id
     * @return JsonResponse
     */
    public function show(RecipeRepository $recipe, int $id): JsonResponse
    {
        try {
//            return new RecipeResource($recipe->get($id));

            return response()->json(['data' => $recipe->get($id)]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
//            return new RecipeResource(['data' => $this->recipe->store($request->all())], Response::HTTP_CREATED);

            return response()->json(['data' => $this->recipe->store($request->all())], Response::HTTP_CREATED);
        } catch (ModelNotFoundException $e) {
            Log::error($e)
            ;
            return \response()->json(['message' => __('Recipe with provided ID not found.')], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error($e);

            return \response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        try {
            $recipe = $this->recipe->update($id, $request->all());

            return response()->json(['data' => $recipe]);
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->recipe->delete($id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            Log::error($e);

            return \response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
