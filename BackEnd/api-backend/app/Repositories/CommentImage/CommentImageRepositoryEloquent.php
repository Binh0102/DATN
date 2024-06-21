<?php

namespace App\Repositories\CommentImage;

use App\Models\CommentImage;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ImageRepositoryEloquent.
 *
 * @package namespace App\Repositories\Image;
 */
class CommentImageRepositoryEloquent extends BaseRepository implements CommentImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CommentImage::class;
    }
}
