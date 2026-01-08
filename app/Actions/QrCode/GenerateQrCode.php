<?php

namespace App\Actions\QrCode;

use App\Data\QrCodeResult;
use App\Models\Pet;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    /**
     * Generates a QR code for a given pet.
     *
     * @param  Pet  $pet  The pet to generate the QR code for.
     * @return QrCodeResult The QR code result.
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
