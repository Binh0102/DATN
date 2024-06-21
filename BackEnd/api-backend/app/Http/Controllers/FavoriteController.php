<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\FavoriteResource;
use App\Services\Favorite\FavoriteService;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use APIResponseTrait;

    public function __construct(
        protected FavoriteService $favoriteService,

    ) {
    }

    public function getAll(): JsonResponse
    {
        try {
            $data = $this->favoriteService->getAll();

            return $this->successResponse(FavoriteResource::collection($data), 'successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    public function addFavorite(CartRequest $request): JsonResponse
    {
        try {
            $params = $request->validated();
            $favorites = $this->favoriteService->getAll();
            foreach ($favorites as $favorite) {
                if ($favorite->product_id == $params['product_id']) {
                    return $this->errorResponse($favorite, 'existed', 409);
                }
            }
            $data = $this->favoriteService->addFavorite($params);

            return $this->successResponse($data, 'successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function deleteFavorite(int $id): JsonResponse
    {
        try {
            $data = $this->favoriteService->deleteFavorite($id);

            return $this->successResponse($data, 'successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }
}
