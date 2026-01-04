<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\UpdatePet;
use Tests\TestCase;

class UpdatePetTest extends TestCase
{
    public function test_update_pet_action_updates_pet()
    {
        $pet = \Mockery::mock(\App\Models\Pet::class)->makePartial();
        $updateData = [
            'name' => 'Max',
            'notes' => 'Very friendly',
        ];
        $pet->shouldReceive('update')
            ->once()
            ->with($updateData)
            ->andReturn($pet);
        $pet->name = 'Max';
        $pet->notes = 'Very friendly';

        $action = new UpdatePet;
        $updatedPet = $action($pet, $updateData);
        $this->assertEquals('Max', $updatedPet->name);
        $this->assertEquals('Very friendly', $updatedPet->notes);
    }
}
