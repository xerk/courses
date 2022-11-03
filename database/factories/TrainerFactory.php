<?php

namespace Database\Factories;

use App\Models\Trainer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trainer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company' => $this->faker->numberBetween(0, 127),
            'occupation' => $this->faker->text(255),
            'work_place' => $this->faker->text(255),
            'sufer_diseases' => $this->faker->numberBetween(0, 127),
            'diseases_note' => $this->faker->text,
            'job_title' => $this->faker->text(255),
            'note' => $this->faker->text,
            'user_id' => \App\Models\User::factory(),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
