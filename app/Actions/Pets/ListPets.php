<?php

namespace App\Actions\Pets;

use App\Models\User;
use App\Repositories\Pets\PetRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ListPets
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Return a collection of all pets for a user
     *
     * @param  User  $user  The user to get the pets for
     * @return Collection The collection of pets
     */
    public function __invoke(User $user): Collection
    {
        return $this->pets->listForUser($user);
    }
}
