<?php

namespace Tests\Feature\Pets;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListPetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_pets(): void
    {
        $user = User::factory()->create();
        $pets = Pet::factory()->count(3)->for($user)->create();
        $this->actingAsApi($user);

        $response = $this->getJson(route('pets.index'));
        $response->assertOk();
        foreach ($pets as $pet) {
            $response->assertJsonFragment([
                'id' => $pet->id,
                'name' => $pet->name,
            ]);
        }
    }

    public function test_guest_cannot_list_pets(): void
    {
        $response = $this->getJson(route('pets.index'));
        $response->assertUnauthorized();
    }
}
