<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;

class DeletePet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Delete a pet belonging to a user
     *
     * @param  User  $user  The user owning the pet
     * @param  Pet  $pet  The pet to delete
     */
    public function __invoke(User $user, Pet $pet): void
    {
        $this->pets->delete($pet);
    }
}
