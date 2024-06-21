<?php

namespace App\Http\Controllers;

use App\Helper\ImageManagerTrait;
use App\Http\Requests\Comment\ImageCommentImageRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\Comment\CommentService;
use App\Services\CommentImage\CommentImageService;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use APIResponseTrait, ImageManagerTrait;

    public function __construct(protected CommentService $commentService, protected CommentImageService $commentImageService)
    {
    }

    public function getCommentByProduct(int $id): JsonResponse
    {
        try {
            $data = $this->commentService->getCommentByProduct($id);
            return $this->successResponse(CommentResource::collection($data), 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function addComment(CommentRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $params = $request->validated();
            $params['user_id'] = $user->id;
            $data = $this->commentService->addComment($params);
            if (isset($params['commentImages'])) {
                $this->addImageComment($data, $request->validated());
            }
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    private function addImageComment(Comment $comment, mixed $request): void
    {
        $data['comment_id'] = $comment->id;
        if ($request['commentImages']) {
            foreach ($request['commentImages'] as $image) {
                if ($image['image']) {
                    $fileData = $this->uploads($image['image']);
                    $data['image'] = $fileData['path'];
                }
                $this->commentImageService->storeImage($data);
            }
        }
    }
}
