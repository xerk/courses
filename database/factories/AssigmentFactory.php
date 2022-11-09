<?php

namespace Database\Factories;

use App\Models\Assigment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssigmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assigment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'dead_line' => $this->faker->dateTime,
            'points' => $this->faker->randomNumber(0),
            'body' => $this->faker->text,
            'user_id' => \App\Models\User::factory(),
            'course_group_id' => \App\Models\CourseGroup::factory(),
        ];
    }
}
