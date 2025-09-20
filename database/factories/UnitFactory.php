<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $types = ['apartment', 'room', 'office', 'store', 'other'];
        $type = $this->faker->randomElement($types);
        $number = $this->faker->numberBetween(1, 100);

        return [
            'name' => ucfirst($type) . ' ' . $number,
            'building_id' => null,
            'floor' => $this->faker->numberBetween(0, 20),
            'type' => $type,
        ];
    }
}
