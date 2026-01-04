<?php

namespace App\Actions\Pets;

use App\Models\User;
use Illuminate\Support\Collection;

class ListPets
{
    /**
     * List all pets for a user
     */
    public function __invoke(User $user): Collection
    {
        return $user->pets()->get();
    }
}
