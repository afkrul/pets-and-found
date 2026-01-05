<?php

namespace App\Actions\QrCode;

use App\Models\Pet;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


class GenerateQrCode

{
  
    public function __invoke(Pet $pet)
    {
        if (!$pet->qr_code) {
            $pet->qr_code = Str::ulid()->toBase32();
            $pet->save();
        }

        $payload = url("/qr/{$pet->qr_code}");
        $png = QrCode::format('png')
            ->size(512)
            ->margin(1)
            ->errorCorrection('M')
            ->generate($payload);

        $path = "qr/pets/{$pet->id}.png";
        Storage::disk('public')->put($path, $png);

        return [
            'code' => $pet->qr_code,
            'image_url' => Storage::disk('public')->url($path),
        ];
    }
}