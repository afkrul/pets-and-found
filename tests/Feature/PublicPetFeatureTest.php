<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPetFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_public_pet_by_qr_code()
    {
        $user = User::factory()->create(['name' => 'Owner One', 'email' => 'owner@example.com']);

        $pet = Pet::factory()->for($user)->create([
            'qr_code' => 'TESTQR123',
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Very friendly',
        ]);

        $response = $this->getJson('/api/public/pets/TESTQR123');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'pet' => ['name', 'type', 'breed', 'notes'],
                'owner' => ['name'],
            ])
            ->assertJson(['pet' => ['name' => 'Buddy'], 'owner' => ['name' => 'Owner One']]);

        // Ensure sensitive fields are not exposed
        $response->assertJsonMissing(['id' => $pet->id]);
        $response->assertJsonMissing(['user_id' => $user->id]);
        $response->assertJsonMissing(['email' => $user->email]);
    }

    public function test_returns_404_for_unknown_qr_code()
    {
        $response = $this->getJson('/api/public/pets/NOTFOUND');

        $response->assertStatus(404);
    }
}
