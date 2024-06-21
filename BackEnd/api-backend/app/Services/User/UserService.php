<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

interface UserService
{
    /**
     * @return UserRepository
     */
    public function getRepository(): UserRepository;

    public function getAll(): Collection;

    public function getUserByid(int $id): ?User;

    public  function createUser(array $abttribute): ?User;

    public function login(array $abttribute);

    public function forgotPasword(array $abttribute);

    public function checkToken(string $token): ?User;

    public function resetPassword(array $abttribute);

    public function getUserByRole(int $role): Collection;

    public function updateInfo(array $attribute): ?User;

    public function updateRole(int $id, array $attributes): ?User;
}
