<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Repositories\Pets\PetRepositoryInterface;

class DeletePet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Delete a pet
     *
     * @param  Pet  $pet  The pet to delete
     */
    public function __invoke(Pet $pet): void
    {
        $this->pets->delete($pet);
    }
}
