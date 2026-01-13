<?php

namespace Tests\Unit\Auth;

use App\Actions\Auth\Register;
use App\Data\Auth\RegisterData;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;
use Mockery;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    public function test_creates_user_and_delegates_to_repository(): void
    {
        $user = new User(['name' => 'Repo User', 'email' => 'repo@example.com']);
        $user->id = 10;

        $repo = Mockery::mock(UserRepositoryInterface::class);
        $repo->shouldReceive('create')
            ->once()
            ->withArgs(function (RegisterData $data) {
                return $data->name === 'Repo User' && $data->email === 'repo@example.com' && $data->password === 'plainpass';
            })
            ->andReturn($user);

        $action = new Register($repo);
        $result = $action(new RegisterData('Repo User', 'repo@example.com', 'plainpass'));

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals(10, $result->id);
    }
}
