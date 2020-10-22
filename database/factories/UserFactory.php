<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => 'jindon27@gmail.com',
            'phone' => $this->faker->numberBetween(1000000000, 9999999999),
            'email_verified_at' => now(),
            'password' => Hash::make('welcome27'),
            'status' => true,
            'role' => 'superadmin',
            'remember_token' => Str::random(10),
        ];
    }
}
