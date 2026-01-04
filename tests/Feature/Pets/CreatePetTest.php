<?php

namespace Tests\Feature\Pets;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_pet()
    {
        $user = User::factory()->create();
        $this->actingAsApi($user);

        $petData = [
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Friendly dog',
        ];

        $response = $this->postJson(route('pets.store'), $petData);

        $response->assertCreated();
        $this->assertDatabaseHas('pets', [
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Friendly dog',
            'user_id' => $user->id,
        ]);
    }

    public function test_guest_cannot_create_pet()
    {
        $petData = [
            'name' => 'Kitty',
            'type' => 'Cat',
            'breed' => 'Siamese',
            'notes' => 'Shy cat',
        ];

        $response = $this->postJson(route('pets.store'), $petData);
        $response->assertUnauthorized();
    }
}
