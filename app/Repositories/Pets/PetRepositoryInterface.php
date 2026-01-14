<?php

namespace App\Repositories\Pets;

use App\Data\Pets\CreatePetData;
use App\Data\Pets\UpdatePetData;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PetRepositoryInterface
{
    public function listForUser(User $user): Collection;

    public function find(int $id): Pet;

    public function createForUser(User $user, CreatePetData $data): Pet;

    public function update(Pet $pet, UpdatePetData $data): Pet;

    public function delete(Pet $pet): void;

    public function getByQrCode(string $qrCode): Pet;
}
