<?php

namespace App\Actions\Pets;

use App\Models\Pet;

class UpdatePet
{
    /**
     * Update a pet in the database.
     *
     * @param  Pet  $pet  The pet to update
     * @param  array  $petData  The data to update the pet with
     * @return Pet The updated pet
     */
    public function __invoke(Pet $pet, array $petData): Pet
    {
        $pet->update($petData);

        return $pet;
    }
}
