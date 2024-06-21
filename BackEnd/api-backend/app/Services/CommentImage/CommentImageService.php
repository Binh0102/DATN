<?php

namespace App\Services\CommentImage;

use App\Models\CommentImage;
use App\Repositories\CommentImage\CommentImageRepository;

interface CommentImageService
{
    public function getRepository(): CommentImageRepository;

    public function storeImage(array $attributes): ?CommentImage;
}
