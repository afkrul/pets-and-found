<?php

namespace App\Actions\QrCode;

use App\Models\Pet;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use App\Data\QrCodeResult;


class GenerateQrCode
{
    public function __invoke(Pet $pet): QrCodeResult
    {
        if (!$pet->qr_code) {
            $pet->qr_code = Str::ulid()->toBase32();
            $pet->save();
        }

        $payload = url("/qr/{$pet->qr_code}");
        
        $svg = QrCode::format('svg')
            ->size(512)
            ->margin(1)
            ->errorCorrection('M')
            ->generate($payload);
        return new QrCodeResult(
            code: $pet->qr_code,
            bytes: $svg,
            mime: 'image/svg+xml',
            filename: "pet-{$pet->id}-qr.svg",
        );
    }
}