<?php

namespace App\Actions\Pets;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ListPets
{
    /**
     * Fetch all pets belonging to a user
     */
    public function __invoke(User $user): Collection
    {
        return $user->pets()->get();
    }
}
