<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\UpdatePet;
use App\Data\Pets\UpdatePetData;
use App\Repositories\Pets\PetRepositoryInterface;
use Tests\TestCase;

class UpdatePetTest extends TestCase
{
    public function test_update_pet_action_updates_pet(): void
    {
        $pet = \Mockery::mock(\App\Models\Pet::class)->makePartial();
        $data = new UpdatePetData(name: 'Max', notes: 'Very friendly');

        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $repo->shouldReceive('update')
            ->once()
            ->with($pet, \Mockery::type(UpdatePetData::class))
            ->andReturn($pet);

        $action = new UpdatePet($repo);
        $updatedPet = $action($pet, $data);
        $this->assertEquals($pet, $updatedPet);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
