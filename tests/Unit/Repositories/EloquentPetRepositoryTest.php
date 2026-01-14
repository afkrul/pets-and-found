<?php

namespace Tests\Unit\Repositories;

use App\Models\Pet;
use App\Models\User;
use App\Repositories\Pets\EloquentPetRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentPetRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_for_user_returns_only_users_pets(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Pet::factory()->create(['user_id' => $user1->id, 'name' => 'A']);
        Pet::factory()->create(['user_id' => $user2->id, 'name' => 'B']);
        Pet::factory()->create(['user_id' => $user1->id, 'name' => 'C']);

        $repo = new EloquentPetRepository;
        $collection = $repo->listForUser($user1);

        $this->assertCount(2, $collection);
        foreach ($collection as $pet) {
            $this->assertEquals($user1->id, $pet->user_id);
        }
    }

    public function test_get_by_qr_code_finds_pet_with_owner(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id, 'qr_code' => 'ABC123']);

        $repo = new EloquentPetRepository;
        $found = $repo->getByQrCode('ABC123');

        $this->assertInstanceOf(Pet::class, $found);
        $this->assertEquals($pet->id, $found->id);
        $this->assertNotNull($found->user);
        $this->assertEquals($user->id, $found->user->id);
    }
}
