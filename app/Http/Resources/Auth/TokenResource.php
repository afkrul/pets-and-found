<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'access_token' => $this->resource['access_token'],
            'token_type' => $this->resource['token_type'] ?? 'Bearer',
        ];
    }
}
