<?php

namespace App\Actions\Auth;

use App\Models\User;

class CreateToken
{
    /**
     * Generate a plain text token for the given user.
     *
     * @param  User $user
     * @return string
     */
    public function __invoke(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}
