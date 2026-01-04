<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login
{
    /**
     * Log in a user with the given credentials and return an authentication token
     * If the credentials are invalid, return null
     *
     * @return string|null
     */
    public function __invoke(array $data): ?User
    {
        return $this->checkUserCredentials($data);
    }

    /**
     * Check if the given user credentials are valid
     */
    private function checkUserCredentials(array $data): ?User
    {
        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }

        return null;
    }
}
