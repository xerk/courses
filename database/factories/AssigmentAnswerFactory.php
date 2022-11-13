<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AssigmentAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssigmentAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssigmentAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => 'approved',
            'reason' => $this->faker->text,
            'assigment_id' => \App\Models\Assigment::factory(),
            'user_id' => \App\Models\User::factory(),
            'instructor_id' => \App\Models\User::factory(),
        ];
    }
}
