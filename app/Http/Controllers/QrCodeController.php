<?php

namespace App\Http\Controllers;

use App\Actions\QrCode\GenerateQrCode;
use App\Http\Requests\QrCode\ShowQrCodeRequest;
use App\Http\Responses\QrCodeDownloadResponse;
use App\Models\Pet;

class QrCodeController extends Controller
{
    /**
     * Return a QR code for a given pet.
     *
     *
     * @return QrCodeDownloadResponse
     */
    public function getQrCode(ShowQrCodeRequest $request, Pet $pet, GenerateQrCode $generateQrCode)
    {
        $result = $generateQrCode($pet);

        return new QrCodeDownloadResponse($result);
    }
}
