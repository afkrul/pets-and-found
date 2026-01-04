<?php

namespace App\Http\Requests\Pets;

use Illuminate\Foundation\Http\FormRequest;

class ShowPetRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pet = $this->route('pet');

        return $pet && $this->user()->can('view', $pet);
    }

    public function rules(): array
    {
        return [];
    }
}
