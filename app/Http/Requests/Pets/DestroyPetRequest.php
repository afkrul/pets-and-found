<?php

namespace App\Http\Requests\Pets;

use App\Models\Pet;
use Illuminate\Foundation\Http\FormRequest;

class DestroyPetRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $pet = $this->route('pet');

        return $user && $pet instanceof Pet ? $user->can('delete', $pet) : false;
    }

    public function rules(): array
    {
        return [];
    }
}
