<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\ListPets;
use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ListPetsTest extends TestCase
{
    public function test_list_pet_action_returns_pets(): void
    {
        $user = \Mockery::mock(User::class);
        $pets = new Collection([
            new \App\Models\Pet(['name' => 'Buddy']),
            new \App\Models\Pet(['name' => 'Max']),
            new \App\Models\Pet(['name' => 'Kitty']),
        ]);

        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $repo->shouldReceive('listForUser')
            ->once()
            ->with($user)
            ->andReturn($pets);

        $action = new ListPets($repo);
        $result = $action($user);
        $this->assertCount(3, $result);
        $this->assertEquals(['Buddy', 'Max', 'Kitty'], $result->pluck('name')->values()->toArray());
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
