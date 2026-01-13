<?php

namespace Tests\Unit\Auth;

use App\Actions\Auth\Login;
use App\Data\Auth\LoginData;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_logs_in_valid_user(): void
    {
        $user = new User(['email' => 'valid@example.com', 'password' => Hash::make('secret')]);
        $user->id = 1;

        $repo = Mockery::mock(UserRepositoryInterface::class);
        $repo->shouldReceive('findByEmail')
             ->once()
             ->with('valid@example.com')
             ->andReturn($user);

        Auth::shouldReceive('login')->once()->with($user);

        $action = new Login($repo);
        $result = $action(new LoginData('valid@example.com', 'secret'));

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals(1, $result->id);
    }

    public function test_fails_with_invalid_password(): void
    {
        $user = new User(['email' => 'valid2@example.com', 'password' => Hash::make('secret')]);
        $user->id = 2;

        $repo = Mockery::mock(UserRepositoryInterface::class);
        $repo->shouldReceive('findByEmail')
             ->once()
             ->with('valid2@example.com')
             ->andReturn($user);

        Auth::shouldReceive('login')->never();

        $action = new Login($repo);
        $result = $action(new LoginData('valid2@example.com', 'wrong'));

        $this->assertNull($result);
    }
}
