<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class CreatePet
{
    /**
     * Create a new pet
     *
     * @param  array  $petData
     */
    public function __invoke(User $user, $petData): Pet
    {
        return $user->pets()->create($petData);
    }
}
