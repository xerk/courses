<?php

namespace Database\Factories;

use App\Models\FollowUp;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FollowUp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'follow_date' => $this->faker->date,
            'next_follow_date' => $this->faker->date,
            'Note' => $this->faker->text,
            'status' => $this->faker->word,
            'follow_up_from' => 'visit',
            'lead_id' => \App\Models\Lead::factory(),
            'company_lead_id' => \App\Models\CompanyLead::factory(),
        ];
    }
}
