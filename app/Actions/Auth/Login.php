<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Data\Auth\LoginData;
use App\Repositories\Users\UserRepositoryInterface;

class Login
{
    public function __construct(private UserRepositoryInterface $users)
    {
    }

    public function __invoke(LoginData $data): ?User
    {
        $user = $this->users->findByEmail($data->email);

        if (! $user || ! Hash::check($data->password, $user->password)) {
            return null;
        }

        Auth::login($user);

        return $user;
    }
}
