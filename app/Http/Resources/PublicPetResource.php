<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicPetResource extends JsonResource
{
    /**
     * Disable the outer `data` wrapper for this resource.
     *
     * @var string|null
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'pet' => [
                'name' => $this->name,
                'type' => $this->type,
                'breed' => $this->breed,
                'notes' => $this->notes,
            ],
            'owner' => [
                'name' => optional($this->user)->name,
            ],
        ];
    }
}
