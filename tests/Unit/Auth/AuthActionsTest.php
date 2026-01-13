<?php

namespace Tests\Unit\Auth;

use App\Actions\Auth\Login;
use App\Actions\Auth\Register;
use App\Data\Auth\LoginData;
use App\Data\Auth\RegisterData;
use App\Repositories\Users\EloquentUserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_action_creates_user(): void
    {
        $action = new Register(new EloquentUserRepository());
        $user = $action(new RegisterData('Unit User', 'unituser@example.com', 'unitpassword'));
        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'unituser@example.com']);
        $this->assertTrue(Hash::check('unitpassword', $user->password));
    }

    public function test_login_action_returns_user_on_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'unitlogin@example.com',
            'password' => bcrypt('unitpassword'),
        ]);
        $action = new Login(new EloquentUserRepository());
        $result = $action(new LoginData('unitlogin@example.com', 'unitpassword'));
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
    }

    public function test_login_action_returns_null_on_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'unitfail@example.com',
            'password' => bcrypt('unitpassword'),
        ]);
        $action = new Login(new EloquentUserRepository());
        $result = $action(new LoginData('unitfail@example.com', 'wrongpassword'));
        $this->assertNull($result);
    }
}
