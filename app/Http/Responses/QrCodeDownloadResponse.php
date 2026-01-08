<?php

namespace App\Http\Responses;

use App\Data\QrCodeResult;
use Illuminate\Contracts\Support\Responsable;

class QrCodeDownloadResponse implements Responsable
{
    public function __construct(
        protected QrCodeResult $result,
    ) {}

    public function toResponse($request): \Illuminate\Http\Response
    {
        $disposition = $this->result->disposition;

        return response($this->result->bytes)
            ->header('Content-Type', $this->result->mime)
            ->header('Content-Disposition', $disposition.'; filename="'.$this->result->filename.'"');
    }
}
