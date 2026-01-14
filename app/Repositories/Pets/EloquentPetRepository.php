<?php

namespace App\Repositories\Pets;

use App\Data\Pets\CreatePetData;
use App\Data\Pets\UpdatePetData;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

final class EloquentPetRepository implements PetRepositoryInterface
{
    public function listForUser(User $user): Collection
    {
        return $user->pets()->get();
    }

    public function find(int $id): Pet
    {
        return Pet::findOrFail($id);
    }

    public function createForUser(User $user, CreatePetData $data): Pet
    {
        return $user->pets()->create($data->toArray());
    }

    public function update(Pet $pet, UpdatePetData $data): Pet
    {
        $pet->update($data->toArray());

        return $pet;
    }

    public function delete(Pet $pet): void
    {
        $pet->delete();
    }

    public function getByQrCode(string $qrCode): Pet
    {
        return Pet::where('qr_code', $qrCode)->with('user')->firstOrFail();
    }
}
