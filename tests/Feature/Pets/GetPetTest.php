<?php

namespace Tests\Feature\Pets;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_get_pet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create();
        $this->actingAsApi($user);

        $response = $this->getJson(route('pets.show', $pet));
        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $pet->id,
            'name' => $pet->name,
        ]);
    }

    public function test_authenticated_user_cannot_get_other_users_pet()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $pet = Pet::factory()->for($otherUser)->create();
        $this->actingAsApi($user);

        $response = $this->getJson(route('pets.show', $pet));
        $response->assertNotFound();
    }

    public function test_guest_cannot_get_pet()
    {
        $pet = Pet::factory()->for(User::factory()->create())->create();
        $response = $this->getJson(route('pets.show', $pet));
        $response->assertUnauthorized();
    }
}
