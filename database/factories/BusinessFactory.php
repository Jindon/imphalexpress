<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location_id' => $this->faker->randomElement([1,2,3,4,5]),
            'name' => $this->faker->name,
            'phone' => $this->faker->numberBetween(1000000000, 9999999999),
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['0', '1']),
            'created_at' => $this->faker->dateTimeBetween('-5 months', 'now')
        ];
    }
}
