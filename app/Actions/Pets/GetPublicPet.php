<?php

namespace App\Actions\Pets;

use App\Models\Pet;
use App\Repositories\Pets\PetRepositoryInterface;

class GetPublicPet
{
    public function __construct(private PetRepositoryInterface $pets) {}

    /**
     * Return a public pet by its QR code.
     *
     * @param  string  $qrCode  The pet's QR code
     * @return Pet The pet
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function __invoke(string $qrCode): Pet
    {
        return $this->pets->getByQrCode($qrCode);
    }
}
