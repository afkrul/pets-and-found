<?php

return [
    // Use GD instead of Imagick to avoid requiring the imagick extension
    'image_driver' => 'gd',

    // Frontend URL for QR code links
    'frontend_url' => env('FRONTEND_URL', 'http://localhost:5173'),
];
