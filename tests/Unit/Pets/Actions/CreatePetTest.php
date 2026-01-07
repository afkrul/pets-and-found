<?php

namespace Tests\Unit\Pets\Actions;

use App\Actions\Pets\CreatePet;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_pet_action_creates_pet(): void
    {
        $user = User::factory()->create();
        $petData = [
            'name' => 'Buddy',
            'type' => 'Dog',
            'breed' => 'Labrador',
            'notes' => 'Friendly dog',
        ];

        $action = new CreatePet;
        $result = $action($user, $petData);

        $this->assertInstanceOf(Pet::class, $result);
        $this->assertEquals('Buddy', $result->name);
        $this->assertEquals('Dog', $result->type);
        $this->assertEquals('Labrador', $result->breed);
        $this->assertEquals('Friendly dog', $result->notes);
        $this->assertNotNull($result->qr_code);
        $this->assertNotEmpty($result->qr_code);
    }
}
