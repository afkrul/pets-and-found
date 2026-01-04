<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\CreatePet;
use App\Models\User;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    public function test_create_pet_action_creates_pet()
    {
        $user = \Mockery::mock(User::class);
        $petData = [
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Friendly dog',
        ];
        $pet = new \App\Models\Pet($petData);
        $user->shouldReceive('pets->create')
            ->once()
            ->with($petData)
            ->andReturn($pet);

        $action = new CreatePet;
        $result = $action($user, $petData);
        $this->assertEquals('Buddy', $result->name);
        $this->assertEquals('Dog', $result->type);
        $this->assertEquals('Labrador', $result->breed);
        $this->assertEquals('Friendly dog', $result->notes);
    }
}
