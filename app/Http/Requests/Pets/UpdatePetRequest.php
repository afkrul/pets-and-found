<?php

namespace App\Http\Requests\Pets;

use App\Data\Pets\UpdatePetData;
use App\Models\Pet;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $pet = $this->route('pet');

        if (! $user) {
            return false;
        }

        return $pet instanceof Pet ? $user->can('update', $pet) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Return a typed DTO representing this request
     */
    public function dto(): UpdatePetData
    {
        return UpdatePetData::fromRequest($this);
    }
}
