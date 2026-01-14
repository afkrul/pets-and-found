<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\DeletePet;
use App\Repositories\Pets\PetRepositoryInterface;
use Tests\TestCase;

class DeletePetTest extends TestCase
{
    public function test_delete_pet_action_deletes_pet(): void
    {
        $pet = \Mockery::mock(\App\Models\Pet::class)->makePartial();

        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $repo->shouldReceive('delete')
            ->once()
            ->with($pet)
            ->andReturnNull();

        $action = new DeletePet($repo);
        $action($pet);
        $this->addToAssertionCount(1); // Acknowledge mock expectation as assertion
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
