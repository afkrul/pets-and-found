<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\ListPets;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class ListPetsTest extends TestCase
{
    public function test_list_pet_action_returns_pets()
    {
        $user = \Mockery::mock(User::class);
        $pets = new Collection([
            new \App\Models\Pet(['name' => 'Buddy']),
            new \App\Models\Pet(['name' => 'Max']),
            new \App\Models\Pet(['name' => 'Kitty']),
        ]);

        $petsRelation = \Mockery::mock('Illuminate\Database\Eloquent\Relations\HasMany');
        $petsRelation->shouldReceive('get')
            ->once()
            ->andReturn($pets);

        $user->shouldReceive('pets')
            ->once()
            ->andReturn($petsRelation);

        $action = new ListPets;
        $result = $action($user);
        $this->assertCount(3, $result);
        $this->assertEquals(['Buddy', 'Max', 'Kitty'], $result->pluck('name')->values()->toArray());
    }
}
