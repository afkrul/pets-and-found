<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register
{
    /**
     * Registers a new user.
     *
     * @param array $data user data
     * @return User new user instance
     */
    public function __invoke(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
