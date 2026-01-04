<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\GetPet;
use Tests\TestCase;

class GetPetTest extends TestCase
{
    public function test_get_pet_action_returns_pet()
    {
        $action = new GetPet;
        $user = \Mockery::mock(\App\Models\User::class)->makePartial();
        $pet = \Mockery::mock(\App\Models\Pet::class)->makePartial();
        $pet->id = 1;
        $pet->name = 'Buddy';
        $user->shouldReceive('pets->findOrFail')
            ->once()
            ->with(1)
            ->andReturn($pet);

        $foundPet = $action($user, $pet->id);
        $this->assertEquals(1, $foundPet->id);
        $this->assertEquals('Buddy', $foundPet->name);
    }
}
