<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login
{
    /**
     * Attempt to find a user with the given credentials.
     *
     * @param  array  $data  The user credentials.
     */
    public function __invoke(array $data): ?User
    {
        return $this->checkUserCredentials($data);
    }

    /**
     * Check if the given user credentials match with a user in the database.
     *
     * @param  array  $data  The user credentials.
     */
    private function checkUserCredentials(array $data): ?User
    {
        $user = User::where('email', $data['email'])->first();
        $password = $data['password'] ?? '';

        // Always perform a hash check to mitigate timing attacks
        if ($user) {
            if (Hash::check($password, $user->password)) {
                return $user;
            }
        } else {
            // Use a dummy hash to ensure timing is consistent
            Hash::check($password, '$2y$10$'.str_repeat('a', 53));
        }

        return null;
    }
}
