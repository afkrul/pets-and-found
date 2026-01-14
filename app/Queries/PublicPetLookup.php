<?php

namespace App\Queries;

use App\Models\Pet;
use App\Repositories\Pets\PetRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class PublicPetLookup
{
    public function __construct(private PetRepositoryInterface $repo) {}

    /**
     * Find a public pet by its QR code.
     *
     * If the pet does not exist the repository will throw a ModelNotFoundException.
     * Note: creating a Pet record requires an owning User and domain data; that
     * responsibility belongs to a different part of the system (repository/service).
     */
    public function byQrCode(string $qrCode): Pet
    {
        return $this->repo->getByQrCode($qrCode);
    }
}
