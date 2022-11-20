<?php

namespace Database\Factories;

use App\Models\CompanyLead;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyLeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyLead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'name_ar' => $this->faker->text(255),
            'email' => $this->faker->email,
            'business_email' => $this->faker->text(255),
            'phone' => $this->faker->phoneNumber,
            'business_landline' => $this->faker->text(255),
            'status' => $this->faker->word,
            'note' => $this->faker->text,
            'category_id' => \App\Models\Category::factory(),
            'sub_category_id' => \App\Models\SubCategory::factory(),
            'sales_id' => \App\Models\User::factory(),
        ];
    }
}
