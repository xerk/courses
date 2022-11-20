<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'course_type' => $this->faker->text(255),
            'lead_from' => 'website',
            'note' => $this->faker->text,
            'category_id' => \App\Models\Category::factory(),
            'sub_category_id' => \App\Models\SubCategory::factory(),
            'sales_id' => \App\Models\User::factory(),
        ];
    }
}
