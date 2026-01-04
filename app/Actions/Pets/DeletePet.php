<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Models\User;

class DeletePet
{
    /**
     * Delete a pet belonging to a user
     *
     * @param  User  $user  The user owning the pet
     * @param  Pet  $pet  The pet to delete
     * @return bool Whether the deletion was successful
     */
    public function __invoke(User $user, Pet $pet): bool
    {
        return $user->pets()->findOrFail($pet->id)->delete();
    }
}
