<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'full_name'    => $this->faker->name(),        // ✅ match your column
            'email'        => $this->faker->unique()->safeEmail(),
            'password'     => bcrypt('password'),          // default password
            'phone_number' => $this->faker->phoneNumber(),
            'address'      => $this->faker->address(),
            'remember_token' => Str::random(10),
        ];
    }
}
