<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Data\Auth\RegisterData;
use App\Repositories\Users\UserRepositoryInterface;

class Register
{
    public function __construct(private UserRepositoryInterface $users)
    {
    }

    public function __invoke(RegisterData $data): User
    {
        return $this->users->create($data);
    }
}
