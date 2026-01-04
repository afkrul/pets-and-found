<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login
{

    /**
     * Attempt to find an user with the given credentials.
     *
     * @param array $data The user credentials.
     *
     * @return \App\Models\User|null
     */
    public function __invoke(array $data): ?User
    {
        return $this->checkUserCredentials($data);
    }

    /**
     * Check if the given user credentials match with a user in the database.
     *
     * @param array $data The user credentials.
     *
     * @return \App\Models\User|null
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
