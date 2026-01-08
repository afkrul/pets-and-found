<?php

namespace Tests\Unit;

use App\Http\Resources\PublicPetResource;
use App\Models\Pet;
use App\Models\User;
use Tests\TestCase;

class PublicPetControllerTest extends TestCase
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
}
