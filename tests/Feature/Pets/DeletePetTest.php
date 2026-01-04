<?php

namespace Tests\Feature\Pets;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_delete_pet()
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create();
        $this->actingAsApi($user);

        $response = $this->deleteJson(route('pets.destroy', $pet));
        $response->assertNoContent();
        $this->assertDatabaseMissing('pets', ['id' => $pet->id]);
    }

    public function test_guest_cannot_delete_pet()
    {
        $pet = Pet::factory()->for(User::factory()->create())->create();
        $response = $this->deleteJson(route('pets.destroy', $pet));
        $response->assertUnauthorized();
    }
}
