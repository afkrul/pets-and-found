<?php

namespace Tests\Feature\Pets;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_pet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create([
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Friendly dog',
        ]);
        $this->actingAsApi($user);

        $updateData = [
            'name' => 'Max',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Very friendly',
        ];

        $response = $this->putJson(route('pets.update', $pet), $updateData);
        $response->assertOk();
        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'name' => 'Max',
            'notes' => 'Very friendly',
        ]);
    }

    public function test_authenticated_user_cannot_update_other_users_pet()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $pet = Pet::factory()->for($otherUser)->create();
        $this->actingAsApi($user);

        $updateData = [
            'name' => 'Max',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Very friendly',
        ];
        $response = $this->putJson(route('pets.update', $pet), $updateData);
        $response->assertForbidden();
    }

    public function test_guest_cannot_update_pet()
    {
        $otherUser = User::factory()->create();
        $pet = Pet::factory()->for($otherUser)->create();
        $updateData = [
            'name' => 'Max',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Very friendly',
        ];
        $response = $this->putJson(route('pets.update', $pet), $updateData);
        $response->assertUnauthorized();
    }
}
