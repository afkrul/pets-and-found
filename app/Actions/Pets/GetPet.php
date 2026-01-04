<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class GetPet
{
    /**
     * Return a specific pet belonging to the user
     */
    public function __invoke(User $user, Pet $pet): Pet
    {
        return $user->pets()->findOrFail($pet->id);
    }
}
