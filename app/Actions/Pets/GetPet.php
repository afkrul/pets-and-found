<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Repositories\Pets\PetRepositoryInterface;

class GetPet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Get a pet by ID
     *
     * @param  Pet  $pet  The pet to get
     * @return Pet The pet
     */
    public function __invoke(Pet $pet): Pet
    {
        return $this->pets->find($pet->id);
    }
}
