<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Services\Category\CategoryService;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use APIResponseTrait;

    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            $data = $this->categoryService->getAll();
            return $this->successResponse(CategoryResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getNameCategory(int $id): JsonResponse
    {
        try {
            $data = $this->categoryService->getNameCategory($id);
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
