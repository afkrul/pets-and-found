<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\GetPublicPet;
use App\Models\Pet;
use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;
use Tests\TestCase;

class GetPublicPetTest extends TestCase
{
    public function test_get_public_pet_by_qr_code_returns_pet_with_user()
    {
        $user = User::factory()->make(['name' => 'Owner One']);
        $pet = new Pet([
            'qr_code' => 'QRUNIT123',
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Beagle',
            'notes' => 'Friendly',
        ]);
        $pet->setRelation('user', $user);

        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $repo->shouldReceive('getByQrCode')
            ->once()
            ->with('QRUNIT123')
            ->andReturn($pet);

        $action = new GetPublicPet($repo);

        $result = $action('QRUNIT123');

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertEquals($pet->qr_code, $result->qr_code);
        $this->assertEquals('Owner One', $result->user->name);
    }

    public function test_get_public_pet_handles_null_optional_fields()
    {
        $user = User::factory()->make(['name' => 'Owner Two']);
        $pet = new Pet([
            'qr_code' => 'QRUNITNULL',
            'name' => 'Shadow',
            'type' => 'Cat',
            'breed' => null,
            'notes' => null,
        ]);
        $pet->setRelation('user', $user);

        $repo = \Mockery::mock(PetRepositoryInterface::class);
        $repo->shouldReceive('getByQrCode')
            ->once()
            ->with('QRUNITNULL')
            ->andReturn($pet);

        $action = new GetPublicPet($repo);

        $result = $action('QRUNITNULL');

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertNull($result->breed);
        $this->assertNull($result->notes);
        $this->assertEquals('Owner Two', $result->user->name);
    }
}
