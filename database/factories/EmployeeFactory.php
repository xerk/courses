<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'joining_date' => $this->faker->dateTime,
            'passport_id' => $this->faker->text(255),
            'passport_realse_date' => $this->faker->date,
            'passport_expire_date' => $this->faker->date,
            'national_id' => $this->faker->text(255),
            'national_realse_date' => $this->faker->date,
            'national_expire_date' => $this->faker->date,
            'health_certificate_no' => $this->faker->text(255),
            'health_realse_date' => $this->faker->date,
            'health_expire_date' => $this->faker->date,
            'gross_salary' => $this->faker->randomNumber(2),
            'net_salary' => $this->faker->randomNumber(2),
            'allowances' => $this->faker->randomNumber(2),
            'yearly_vacation' => $this->faker->randomNumber(0),
            'vacation_balance' => $this->faker->text(255),
            'emergancy_name' => $this->faker->text(255),
            'emergancy_phone' => $this->faker->text(255),
            'emergancy_relative_relation' => $this->faker->text(255),
            'note' => $this->faker->text,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
