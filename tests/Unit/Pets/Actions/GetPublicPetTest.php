<?php

namespace Tests\Unit;

use App\Actions\Pets\GetPublicPet;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPublicPetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_public_pet_by_qr_code_returns_pet_with_user()
    {
        $user = User::factory()->create(['name' => 'Owner One']);

        $pet = Pet::factory()->for($user)->create([
            'qr_code' => 'QRUNIT123',
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Beagle',
            'notes' => 'Friendly',
        ]);

        $action = new GetPublicPet;

        $result = $action('QRUNIT123');

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertEquals($pet->id, $result->id);
        $this->assertEquals('Owner One', $result->user->name);
    }

    public function test_get_public_pet_handles_null_optional_fields()
    {
        $user = User::factory()->create(['name' => 'Owner Two']);

        $pet = Pet::factory()->for($user)->create([
            'qr_code' => 'QRUNITNULL',
            'name' => 'Shadow',
            'type' => 'Cat',
            'breed' => null,
            'notes' => null,
        ]);

        $action = new GetPublicPet;

        $result = $action('QRUNITNULL');

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertNull($result->breed);
        $this->assertNull($result->notes);
        $this->assertEquals('Owner Two', $result->user->name);
    }
}
