<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Support\Collection;

interface CommentService
{
    public function getRepository(): CommentRepository;

    public function getAll(): Collection;

    public function getCommentByProduct(int $id): Collection;

    public function addComment(array $attribute): ?Comment;
}
