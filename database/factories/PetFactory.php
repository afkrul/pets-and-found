<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['Dog', 'Cat', 'Bird', 'Other']);
        $breeds = [
            'Dog' => ['Golden Retriever', 'Labrador', 'Beagle', 'Poodle'],
            'Cat' => ['Siamese', 'Persian', 'Maine Coon', 'Bengal'],
            'Bird' => ['Parakeet', 'Cockatiel', 'Canary', 'Finch'],
            'Other' => ['Other'],
        ];

        return [
            'name' => $this->faker->firstName,
            'type' => $type,
            'breed' => $this->faker->randomElement($breeds[$type]),
            'notes' => $this->faker->sentence(),
        ];
    }

    public function dog(): self
    {
        return $this->state(fn () => [
            'type' => 'Dog',
            'breed' => $this->faker->randomElement(['Golden Retriever', 'Labrador', 'Beagle', 'Poodle']),
        ]);
    }

    public function cat(): self
    {
        return $this->state(fn () => [
            'type' => 'Cat',
            'breed' => $this->faker->randomElement(['Siamese', 'Persian', 'Maine Coon', 'Bengal']),
        ]);
    }

    public function bird(): self
    {
        return $this->state(fn () => [
            'type' => 'Bird',
            'breed' => $this->faker->randomElement(['Parakeet', 'Cockatiel', 'Canary', 'Finch']),
        ]);
    }
}
