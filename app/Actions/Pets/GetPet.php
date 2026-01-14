<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;

class GetPet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Get a pet belonging to a user
     *
     * @param  User  $user  The user to get the pet from
     * @param  Pet  $pet  The pet to get
     * @return Pet The pet
     */
    public function __invoke(User $user, Pet $pet): Pet
    {
        return $this->pets->find($pet->id);
    }
}
