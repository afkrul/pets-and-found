<?php

namespace App\Http\Controllers;

use App\Actions\Pets\GetPublicPet;
use App\Http\Resources\PublicPetResource;
use App\Models\Pet;

class PublicPetController extends Controller
{
    /**
     * Return a public pet by its QR code.
     *
     * @param  string  $qrCode  The pet's QR code
     * @return \Illuminate\Http\Response
     */
    public function show(string $qrCode, GetPublicPet $getPublicPet)
    {
        $pet = $getPublicPet($qrCode);

        return new PublicPetResource($pet);
    }
}
