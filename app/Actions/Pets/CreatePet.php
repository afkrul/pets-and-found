<?php

namespace App\Actions\Pets;

use App\Data\Pets\CreatePetData;
use App\Models\Pet;
use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;

class CreatePet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Create a new pet belonging to a user
     *
     * @param  User  $user  The user to create a pet for
     * @param  CreatePetData  $data  The data to create the pet with
     * @return Pet The created pet
     */
    public function __invoke(User $user, CreatePetData $data): Pet
    {
        return $this->pets->createForUser($user, $data);
    }
}
