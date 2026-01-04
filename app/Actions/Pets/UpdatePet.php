<?php

namespace App\Actions\Pets;

use App\Models\Pet;

class UpdatePet
{
    /**
     * Update an existing pet
     */
    public function __invoke(Pet $pet, array $petData): Pet
    {
        $pet->update($petData);

        return $pet;
    }
}
