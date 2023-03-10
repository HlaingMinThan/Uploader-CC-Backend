<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->unique()->uuid(),
            'name' => $this->faker->word() . '.jpg',
            'user_id' => User::factory(),
            'size' => 50000,
            'path' => 'files/' . $this->faker->unique()->word() . '.png'
        ];
    }
}
