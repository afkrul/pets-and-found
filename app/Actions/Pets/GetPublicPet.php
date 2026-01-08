<?php

namespace App\Actions\Pets;

use App\Models\Pet;

class GetPublicPet
{
    /**
     * Retrieve a pet by its QR code for public access.
     */
    public function __invoke(string $qrCode): Pet
    {
        return Pet::where('qr_code', $qrCode)->with('user')->firstOrFail();
    }
}
