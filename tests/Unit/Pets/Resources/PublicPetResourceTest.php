<?php

namespace Tests\Unit\Pets\Resources;

use App\Http\Resources\PublicPetResource;
use App\Models\Pet;
use App\Models\User;
use Tests\TestCase;

class PublicPetResourceTest extends TestCase
{
    public function test_public_pet_resource_formats_payload()
    {
        $user = User::factory()->make(['name' => 'Owner Name']);

        $pet = Pet::factory()->make([
            'name' => 'Buddy',
            'type' => 'Cat',
            'breed' => 'Siamese',
            'notes' => 'Shy',
        ]);

        // attach relation without persisting
        $pet->setRelation('user', $user);

        $resource = new PublicPetResource($pet);

        $payload = $resource->toArray(null);

        $expected = [
            'pet' => [
                'name' => 'Buddy',
                'type' => 'Cat',
                'breed' => 'Siamese',
                'notes' => 'Shy',
            ],
            'owner' => [
                'name' => 'Owner Name',
            ],
        ];

        $this->assertEquals($expected, $payload);
    }

    public function test_public_pet_resource_handles_null_fields_and_missing_owner()
    {
        $pet = Pet::factory()->make([
            'name' => 'Luna',
            'type' => 'Other',
            'breed' => null,
            'notes' => null,
        ]);

        // simulate no owner relation
        $pet->setRelation('user', null);

        $resource = new PublicPetResource($pet);

        $payload = $resource->toArray(null);

        $this->assertArrayHasKey('pet', $payload);
        $this->assertArrayHasKey('owner', $payload);
        $this->assertNull($payload['pet']['breed']);
        $this->assertNull($payload['pet']['notes']);
        $this->assertNull($payload['owner']['name']);
    }
}
