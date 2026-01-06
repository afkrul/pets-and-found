<?php

namespace App\Data;

final class QrCodeResult
{
    public function __construct(
        public readonly string $code,
        public readonly string $bytes,
        public readonly string $mime,
        public readonly string $filename,
        public readonly string $disposition = 'attachment',
    ) {}
}
