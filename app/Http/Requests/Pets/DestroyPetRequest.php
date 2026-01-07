<?php

namespace App\Http\Requests\Pets;

use Illuminate\Foundation\Http\FormRequest;

class DestroyPetRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $pet = $this->route('pet');

        return $pet && $user->can('delete', $pet);
    }

    public function rules(): array
    {
        return [];
    }
}
