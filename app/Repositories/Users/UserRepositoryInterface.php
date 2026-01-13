<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Data\Auth\RegisterData;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function create(RegisterData $data): User;
}
