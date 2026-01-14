<?php

namespace App\Actions\Pets;

use App\Data\Pets\UpdatePetData;
use App\Models\Pet;
use App\Repositories\Pets\PetRepositoryInterface;

class UpdatePet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Update a pet in the database.
     *
     * @param  Pet  $pet  The pet to update
     * @param  UpdatePetData  $data  The data to update the pet with
     * @return Pet The updated pet
     */
    public function __invoke(Pet $pet, UpdatePetData $data): Pet
    {
        return $this->pets->update($pet, $data);
    }
}
