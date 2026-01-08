<?php

namespace App\Actions\Pets;

use App\Models\Pet;

class GetPublicPet
{
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
        return Pet::where('qr_code', $qrCode)->with('user')->firstOrFail();
    }
}
