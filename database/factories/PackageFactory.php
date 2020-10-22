<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $tracking_count = 10000000;
        return [
            'tracking_id' => 'IMEX' . $tracking_count++,
            'location_id' => $this->faker->randomElement([1,2,3,4,5]),
            'business_id' => $this->faker->randomElement([1,2,3,4,5]),
            'delivery_contact' => $this->faker->numberBetween(1000000000, 9999999999),
            'delivery_address' => $this->faker->address,
            'delivery_note' => $this->faker->sentence,
            'collected_on' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'deliver_by' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'status' => $this->faker->randomElement(['processing','received','dispatched','delivered','delayed']),
            'delivered_on' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'out_for_delivery_on' => $this->faker->dateTimeBetween('-5 months', 'now'),
            'reached_location_on' => $this->faker->dateTimeBetween('-5 months', 'now'),
        ];
    }
}
