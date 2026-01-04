<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Authenticate as the given user using Sanctum token for API requests.
     *
     * @param  \App\Models\User  $user
     * @return $this
     */
    public function actingAsApi($user, array $abilities = ['*'])
    {
        $token = $user->createToken('test_token', $abilities)->plainTextToken;

        return $this->withToken($token);
    }
}
