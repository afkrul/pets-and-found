<?php

namespace App\Actions\Pets;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ListPets
{
    /**
     * Return a collection of all pets for a user
     *
     * @param  User  $user  The user to get the pets for
     * @return Collection The collection of pets
     */
    public function __invoke(User $user): Collection
    {
        return $user->pets()->get();
    }
}
