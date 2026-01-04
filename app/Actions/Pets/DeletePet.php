<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class DeletePet
{
    /**
     * Delete a specific pet
     */
    public function __invoke(User $user, Pet $pet): bool
    {
        return $user->pets()->findOrFail($pet->id)->delete();
    }
}
