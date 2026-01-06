<?php

namespace App\Http\Controllers;
use App\Actions\QrCode\GenerateQrCode;
use App\Http\Requests\QrCode\ShowQrCodeRequest;
use App\Models\Pet;
use App\Http\Responses\QrCodeDownloadResponse;


class QrCodeController extends Controller
{
    
    public function getQrCode(ShowQrCodeRequest $request, Pet $pet, GenerateQrCode $generateQrCode)
    {
        $result = $generateQrCode($pet); // QrCodeResult

        return new QrCodeDownloadResponse($result);
    }
}