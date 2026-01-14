<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicPetResource;
use App\Queries\PublicPetLookup;

class PublicPetController extends Controller
{
    /**
     * Return a public pet by its QR code.
     *
     * @param  string  $qrCode  The pet's QR code
     * @return \Illuminate\Http\Response
     */
    public function show(string $qrCode, PublicPetLookup $lookup)
    {
        $pet = $lookup->byQrCode($qrCode);

        return new PublicPetResource($pet);
    }
}
