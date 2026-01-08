<?php

namespace App\Http\Requests\QrCode;

use Illuminate\Foundation\Http\FormRequest;

class ShowQrCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pet = $this->route('pet');

        return $pet && $this->user()->can('generateQrCode', $pet);
    }

    public function rules(): array
    {
        return [];
    }
}
