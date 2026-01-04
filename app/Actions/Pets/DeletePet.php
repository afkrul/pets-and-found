<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class DeletePet
{
    /**
     * Delete a pet belonging to a user
     */
    public function __invoke(User $user, Pet $pet): bool
    {
        return $user->pets()->findOrFail($pet->id)->delete();
    }
}
