<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserServiceEloquent implements UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function getRepository(): UserRepository
    {
        return $this->userRepository;
    }

    public function getAll(): Collection
    {
        return $this->userRepository->get();
    }

    public function getUserByid(int $id): ?User
    {
        return $this->userRepository
            ->where('id', $id)->first();
    }

    public function createUser(array $abttribute): ?User
    {
        return $this->userRepository->create($abttribute);
    }

    public function login(array $abttribute)
    {
        if (Auth::attempt($abttribute)) {
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                $token = $user->createToken('token')->plainTextToken;
                return [$token, $user->role];
            }
        }
        return null;
    }

    public function forgotPasword(array $abttribute)
    {
        return $this->userRepository
            ->where('users.email', $abttribute['email'])
            ->update(['token' => $abttribute['token']]);
    }

    public function checkToken(string $token): ?User
    {
        return $this->userRepository->where('users.token', $token)->first();
    }

    public function resetPassword(array $abttribute)
    {
        return $this->userRepository
            ->where('users.token', $abttribute['token'])
            ->update(['token' => null, 'password' => bcrypt($abttribute['password'])]);
    }

    public function getUserByRole(int $role): Collection
    {
        return $this->userRepository
            ->where('role', 1)
            ->get();
    }

    public function updateInfo(array $attribute): ?User
    {
        $user = Auth::user();
        return $this->userRepository->update($attribute, $user->id);
    }

    public function updateRole(int $id, array $attributes): ?User
    {
        return $this->userRepository->update($attributes, $id);
    }
}
