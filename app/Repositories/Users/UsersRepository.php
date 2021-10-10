<?php

namespace App\Repositories\Users;

use App\Models\Collections\UsersCollection;
use App\Models\User;

interface UsersRepository
{
    public function getAll(): UsersCollection;
    public function checkEmail(User $user): ?User;
    public function register(User $user, string $password): void;
    public function loginAttempt(string $email, string $password): ?User;
}