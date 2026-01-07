<?php

namespace Tests\Feature\Pets;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_pet(): void
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

        // Verify QR code was auto-generated
        $pet = $user->pets()->where('name', 'Buddy')->first();
        $this->assertNotNull($pet->qr_code);
        $this->assertNotEmpty($pet->qr_code);
    }

    public function test_guest_cannot_create_pet(): void
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

    public function test_each_pet_gets_unique_qr_code_on_creation(): void
    {
        $user = User::factory()->create();
        $this->actingAsApi($user);

        $pet1Data = [
            'name' => 'Pet 1',
            'type' => 'Dog',
            'breed' => 'Labrador',
        ];

        $pet2Data = [
            'name' => 'Pet 2',
            'type' => 'Cat',
            'breed' => 'Persian',
        ];

        $response1 = $this->postJson(route('pets.store'), $pet1Data);
        $response2 = $this->postJson(route('pets.store'), $pet2Data);

        $response1->assertCreated();
        $response2->assertCreated();

        $pet1 = $user->pets()->where('name', 'Pet 1')->first();
        $pet2 = $user->pets()->where('name', 'Pet 2')->first();

        $this->assertNotNull($pet1->qr_code);
        $this->assertNotNull($pet2->qr_code);
        $this->assertNotEquals($pet1->qr_code, $pet2->qr_code);
    }
}
