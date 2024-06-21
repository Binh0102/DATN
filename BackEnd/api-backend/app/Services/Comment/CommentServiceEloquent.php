<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use App\Services\Comment\CommentService;
use Illuminate\Support\Collection;

class CommentServiceEloquent implements CommentService
{
    public function __construct(protected CommentRepository $commentRepository)
    {
    }

    public function getRepository(): CommentRepository
    {
        return $this->commentRepository;
    }

    public function getAll(): Collection
    {
        return $this->commentRepository->get();
    }

    public function getCommentByProduct(int $id): Collection
    {
        return $this->commentRepository
            ->where('product_id', $id)
            ->get();
    }

    public function addComment(array $attribute): ?Comment
    {
        return $this->commentRepository->create($attribute);
    }
}
