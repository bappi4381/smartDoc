<?php

namespace Database\Factories;

use App\Models\DiagnosticCenter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiagnosticCenter>
 */
class DiagnosticCenterFactory extends Factory
{
    protected $model = DiagnosticCenter::class;

    public function definition(): array
    {
        $name = fake()->company() . ' Diagnostic Center';

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('###'),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->unique()->numerify('017########'),
            'address_line1' => fake()->streetAddress(),
            'address_line2' => fake()->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => 'Bangladesh',
            'latitude' => fake()->latitude(20.0, 26.0),
            'longitude' => fake()->longitude(88.0, 92.0),
            'rating' => fake()->randomFloat(2, 3.5, 5.0),
            'rating_count' => fake()->numberBetween(10, 500),
            'specializations' => fake()->randomElements([
                'Cardiology',
                'Dermatology',
                'Neurology',
                'Orthopedics',
                'Pediatrics',
                'Oncology',
                'General Medicine',
            ], fake()->numberBetween(2, 4)),
            'is_active' => true,
            'has_available_slots' => fake()->boolean(80),
        ];
    }

    public function inactive(): self
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function withoutAvailability(): self
    {
        return $this->state(fn () => ['has_available_slots' => false]);
    }
}

