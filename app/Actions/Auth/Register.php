<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterData;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;

class Register
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function __invoke(RegisterData $data): User
    {
        return $this->users->create($data);
    }
}
