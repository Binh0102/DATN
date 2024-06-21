<?php

namespace App\Services\CommentImage;

use App\Models\CommentImage;
use App\Repositories\CommentImage\CommentImageRepository;

class CommentImageServiceEloquent implements CommentImageService
{
    public function __construct(protected CommentImageRepository $commentImageRepository)
    {
    }

    public function getRepository(): CommentImageRepository
    {
        return $this->commentImageRepository;
    }

    public function storeImage(array $attributes): ?CommentImage
    {
        return $this->commentImageRepository->create($attributes);
    }
}
