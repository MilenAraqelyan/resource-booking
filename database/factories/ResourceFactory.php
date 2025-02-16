<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word . ' Room',
            'type' => $this->faker->randomElement(['room', 'car', 'equipment']),
            'description' => $this->faker->sentence
        ];
    }
}
