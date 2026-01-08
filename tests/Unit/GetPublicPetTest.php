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
}
