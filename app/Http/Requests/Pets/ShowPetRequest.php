<?php

namespace App\Http\Requests\Pets;

use App\Models\Pet;
use Illuminate\Foundation\Http\FormRequest;

class ShowPetRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pet = $this->route('pet');

        return $pet instanceof Pet ? $this->user()->can('view', $pet) : false;
    }

    public function rules(): array
    {
        return [];
    }
}
