<?php

namespace Tests\Unit\Repositories;

use App\Data\Auth\RegisterData;
use App\Models\User;
use App\Repositories\Users\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_hashes_password_and_persists_user(): void
    {
        $repo = new EloquentUserRepository;

        $data = new RegisterData('Persisted', 'persist@example.com', 'plainpassword');

        $user = $repo->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'persist@example.com']);
        $this->assertTrue(Hash::check('plainpassword', $user->password));
    }
}
