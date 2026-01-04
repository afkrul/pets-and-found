<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class CreatePet
{
    /**
     * Create a new pet belonging to a user
     *
     * @param  User  $user  The user to create a pet for
     * @param  array  $petData  The data to create the pet with
     * @return Pet The created pet
     */
    public function __invoke(User $user, array $petData): Pet
    {
        return $user->pets()->create($petData);
    }
}
