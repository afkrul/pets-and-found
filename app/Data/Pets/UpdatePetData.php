<?php

namespace App\Data\Pets;

final class UpdatePetData
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?string $breed = null,
        public readonly ?string $notes = null,
    ) {}

    /**
     * Convert DTO to array for Eloquent update, excluding null values
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        if ($this->type !== null) {
            $data['type'] = $this->type;
        }

        if ($this->breed !== null) {
            $data['breed'] = $this->breed;
        }

        if ($this->notes !== null) {
            $data['notes'] = $this->notes;
        }

        return $data;
    }

    /**
     * Create DTO from an UpdatePetRequest
     */
    public static function fromRequest(\App\Http\Requests\Pets\UpdatePetRequest $request): self
    {
        $v = $request->validated();

        return new self(
            $v['name'] ?? null,
            $v['type'] ?? null,
            $v['breed'] ?? null,
            $v['notes'] ?? null,
        );
    }
}
