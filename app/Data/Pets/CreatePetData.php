<?php

namespace App\Data\Pets;

final class CreatePetData
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $breed = null,
        public readonly ?string $notes = null,
    ) {}

    /**
     * Convert DTO to array suitable for Eloquent create
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'breed' => $this->breed,
            'notes' => $this->notes,
        ];
    }

    /**
     * Create DTO from a StorePetRequest
     */
    public static function fromRequest(\App\Http\Requests\Pets\StorePetRequest $request): self
    {
        $validData = $request->validated();

        return new self(
            $validData['name'],
            $validData['type'],
            $validData['breed'] ?? null,
            $validData['notes'] ?? null,
        );
    }
}
