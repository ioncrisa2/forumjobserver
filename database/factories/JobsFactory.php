<?php

namespace Database\Factories;

use Illuminate\Http\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class JobsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->numberBetween(1, 15),
            'user_id' => $this->faker->numberBetween(1, 15),
            'job_name' => $this->faker->sentence,
            'job_description' => $this->faker->paragraph,
            'job_type' => $this->faker->word,
            'poster' => 'default.png',
            'end_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
