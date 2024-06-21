<?php

namespace App\Services\Favorite;

use App\Models\Favorite;
use App\Repositories\Favorite\FavoriteRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class FavoriteServiceEloquent implements FavoriteService
{
    public function __construct(protected FavoriteRepository $favoriteRepository)
    {
    }
    public function getRepository(): FavoriteRepository
    {
        return $this->favoriteRepository;
    }

    public function getAll(): Collection
    {
        $user = Auth::user();
        return $this->favoriteRepository
            ->where('user_id', $user->id)
            ->get();
    }

    public function deleteFavorite(int $id): bool
    {
        return $this->favoriteRepository->delete($id);
    }

    public function addFavorite(array $attribute): ?Favorite
    {
        $user = Auth::user();
        $attribute['user_id'] = $user->id;
        return $this->favoriteRepository->create($attribute);
    }
}
