<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_via_api(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['access_token']]);
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    public function test_registration_fails_with_missing_fields(): void
    {
        $response = $this->postJson('/api/register', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_registration_fails_with_invalid_email(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_registration_fails_with_short_password(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser2@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_registration_fails_with_password_mismatch(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser3@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        $user = [
            'name' => 'Test User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $this->postJson('/api/register', $user)->assertCreated();
        $response = $this->postJson('/api/register', $user);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
