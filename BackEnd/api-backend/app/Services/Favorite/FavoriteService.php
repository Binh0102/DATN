<?php

namespace App\Services\Favorite;

use App\Models\Favorite;
use App\Repositories\Favorite\FavoriteRepository;
use Illuminate\Support\Collection;

interface FavoriteService
{
    public function getRepository(): FavoriteRepository;

    public function getAll(): Collection;

    public function deleteFavorite(int $id): bool;

    public function addFavorite(array $abttribute): ?Favorite;
}
