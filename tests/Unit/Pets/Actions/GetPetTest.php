<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\GetPet;
use App\Repositories\Pets\PetRepositoryInterface;
use Tests\TestCase;

class GetPetTest extends TestCase
{
    public function test_get_pet_action_returns_pet(): void
    {
        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $pet = \Mockery::mock(\App\Models\Pet::class)->makePartial();
        $pet->id = 1;
        $pet->name = 'Buddy';

        $repo->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($pet);

        $action = new GetPet($repo);

        $foundPet = $action($pet);
        $this->assertEquals(1, $foundPet->id);
        $this->assertEquals('Buddy', $foundPet->name);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
