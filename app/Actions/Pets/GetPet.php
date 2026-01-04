<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class GetPet
{
    /**
     * Fetch a pet belonging to a user
     */
    public function __invoke(User $user, Pet $pet): Pet
    {
        return $user->pets()->findOrFail($pet->id);
    }
}
