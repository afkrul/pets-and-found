<?php

namespace Tests\Unit\Repositories;

use App\Data\Pets\CreatePetData;
use App\Data\Pets\UpdatePetData;
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

    public function test_create_for_user_creates_pet_with_qr_code(): void
    {
        $user = User::factory()->create();
        $data = new CreatePetData(
            name: 'Fluffy',
            type: 'Cat',
            breed: 'Persian',
            notes: 'Very fluffy',
        );

        $repo = new EloquentPetRepository;
        $pet = $repo->createForUser($user, $data);

        $this->assertInstanceOf(Pet::class, $pet);
        $this->assertEquals('Fluffy', $pet->name);
        $this->assertEquals('Cat', $pet->type);
        $this->assertEquals('Persian', $pet->breed);
        $this->assertEquals('Very fluffy', $pet->notes);
        $this->assertEquals($user->id, $pet->user_id);
        $this->assertNotNull($pet->qr_code);
        $this->assertNotEmpty($pet->qr_code);
    }

    public function test_update_modifies_pet_attributes(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create([
            'user_id' => $user->id,
            'name' => 'OldName',
            'type' => 'Dog',
            'breed' => 'OldBreed',
            'notes' => 'Old notes',
        ]);

        $data = new UpdatePetData(
            name: 'NewName',
            notes: 'Updated notes',
        );

        $repo = new EloquentPetRepository;
        $updated = $repo->update($pet, $data);

        $this->assertEquals('NewName', $updated->name);
        $this->assertEquals('Dog', $updated->type); // Unchanged
        $this->assertEquals('OldBreed', $updated->breed); // Unchanged
        $this->assertEquals('Updated notes', $updated->notes);
        $this->assertEquals($pet->id, $updated->id);
    }

    public function test_delete_removes_pet_from_database(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id]);
        $petId = $pet->id;

        $repo = new EloquentPetRepository;
        $repo->delete($pet);

        $this->assertDatabaseMissing('pets', ['id' => $petId]);
    }

    public function test_find_returns_pet_by_id(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create(['user_id' => $user->id, 'name' => 'Findable']);

        $repo = new EloquentPetRepository;
        $found = $repo->find($pet->id);

        $this->assertInstanceOf(Pet::class, $found);
        $this->assertEquals($pet->id, $found->id);
        $this->assertEquals('Findable', $found->name);
    }
}
