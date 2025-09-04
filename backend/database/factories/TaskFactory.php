<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),                // Random short title
            'description' => $this->faker->paragraph(),         // Random description
            'is_done' => $this->faker->boolean(),               // true/false
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'user_id' => User::factory(),                       // Each task belongs to a user
        ];
    }
}
