<?php

namespace App\Actions\QrCode;

use App\Data\QrCodeResult;
use App\Models\Pet;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    /**
     * Generate a QR code for the given pet.
     *
     * Generate an SVG QR code for the pet's QR code.
     * Return a QrCodeResult containing the QR code, SVG markup as a string, the mime type, and the filename.
     */
    public function __invoke(Pet $pet): QrCodeResult
    {
        $frontendUrl = config('qrcode.frontend_url');
        $payload = "{$frontendUrl}/pet?code={$pet->qr_code}";

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
