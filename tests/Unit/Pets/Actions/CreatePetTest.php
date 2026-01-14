<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\CreatePet;
use App\Data\Pets\CreatePetData;
use App\Models\Pet;
use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    public function test_create_pet_action_creates_pet(): void
    {
        $user = User::factory()->make();
        $data = new CreatePetData(
            name: 'Buddy',
            type: 'Dog',
            breed: 'Labrador',
            notes: 'Friendly dog',
        );

        $createdPet = new Pet([
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Friendly dog',
            'qr_code' => 'QR123',
        ]);

        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $repo->shouldReceive('createForUser')
            ->once()
            ->with($user, \Mockery::type(CreatePetData::class))
            ->andReturn($createdPet);

        $action = new CreatePet($repo);
        $result = $action($user, $data);

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertEquals('Buddy', $result->name);
        $this->assertEquals('Dog', $result->type);
        $this->assertEquals('Labrador', $result->breed);
        $this->assertEquals('Friendly dog', $result->notes);
        $this->assertNotNull($result->qr_code);
        $this->assertNotEmpty($result->qr_code);
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
