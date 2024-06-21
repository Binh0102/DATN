<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use Prettus\Repository\Eloquent\BaseRepository;

class FavoriteRepositoryEloquent extends BaseRepository implements FavoriteRepository
{
    /**
     * 
     * @return string
     */
    public function model(): string
    {
        return Favorite::class;
    }
}
