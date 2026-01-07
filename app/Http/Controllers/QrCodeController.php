<?php

namespace App\Http\Controllers;

use App\Actions\QrCode\GenerateQrCode;
use App\Http\Requests\QrCode\ShowQrCodeRequest;
use App\Models\Pet;
use App\Http\Responses\QrCodeDownloadResponse;


class QrCodeController extends Controller
{

    /**
     * Return a QR code for a given pet.
     *
     * @param ShowQrCodeRequest $request
     * @param Pet $pet
     * @param GenerateQrCode $generateQrCode
     *
     * @return QrCodeDownloadResponse
     */
    public function getQrCode(ShowQrCodeRequest $request, Pet $pet, GenerateQrCode $generateQrCode)
    {
        $result = $generateQrCode($pet);

        return new QrCodeDownloadResponse($result);
    }
}
