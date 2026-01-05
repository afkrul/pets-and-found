<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\DeletePet;
use App\Models\User;
use Tests\TestCase;

class DeletePetTest extends TestCase
{
    public function test_delete_pet_action_deletes_pet(): void
    {
        $pet = \Mockery::mock(\App\Models\Pet::class)->makePartial();
        $user = \Mockery::mock(User::class)->makePartial();

        $user->shouldReceive('pets->findOrFail')
            ->once()
            ->with($pet->id)
            ->andReturn($pet);

        $pet->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $action = new DeletePet;
        $action($user, $pet);
        $this->addToAssertionCount(1); // Acknowledge mock expectation as assertion
    }
}
