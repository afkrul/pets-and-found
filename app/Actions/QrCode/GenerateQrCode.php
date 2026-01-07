<?php

namespace App\Actions\QrCode;

use App\Models\Pet;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Data\QrCodeResult;


class GenerateQrCode
{
    /**
     * Generate a QR code for the given pet.
     *
     * If the pet does not have a QR code, generate a new one.
     * Generate an SVG QR code for the pet's QR code.
     * Return a QrCodeResult containing the QR code, SVG as bytes, the mime type, and the filename.
     *
     * @param \App\Models\Pet $pet
     * @return \App\Data\QrCodeResult
     */
    public function __invoke(Pet $pet): QrCodeResult
    {
        if (!$pet->qr_code) {
            $pet->qr_code = Str::ulid()->toBase32();
            $pet->save();
        }

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
