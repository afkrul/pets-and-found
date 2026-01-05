<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;
        $response = $this->withToken($token)->postJson('/api/logout');
        $response->assertOk()->assertJson(['message' => 'Logged out']);

        // Ensure token is removed
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'token' => hash('sha256', explode('|', $token, 2)[1]),
        ]);

        app('auth')->forgetGuards(); // Clear guard cache

        $failResponse = $this->withToken($token)->getJson(route('pets.index'));
        $failResponse->assertUnauthorized();
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/logout');
        $response->assertUnauthorized();
    }
}
