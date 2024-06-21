<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use Prettus\Repository\Eloquent\BaseRepository;

class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    /**
     * 
     * @return string
     */
    public function model(): string
    {
        return Comment::class;
    }
}
