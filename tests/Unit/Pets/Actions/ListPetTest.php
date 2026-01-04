<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\ListPet;
use App\Models\User;
use Tests\TestCase;

class ListPetTest extends TestCase
{
    public function test_list_pet_action_returns_pets()
    {
        $user = \Mockery::mock(User::class);
        $pets = collect([
            new \App\Models\Pet(['name' => 'Buddy']),
            new \App\Models\Pet(['name' => 'Max']),
            new \App\Models\Pet(['name' => 'Kitty']),
        ]);

        $user->shouldReceive('getAttribute')
            ->with('pets')
            ->andReturn($pets);

        $action = new ListPet();
        $result = $action($user);
        $this->assertCount(3, $result);
        $this->assertEquals(['Buddy', 'Max', 'Kitty'], $result->pluck('name')->values()->toArray());
    }
}
