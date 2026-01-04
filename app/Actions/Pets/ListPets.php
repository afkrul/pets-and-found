<?php

namespace App\Actions\Pets;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ListPets
{
    /**
     * Return a collection of all pets for a user
     */
    public function __invoke(User $user): Collection
    {
        return $user->pets()->get();
    }
}
