<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->text(255),
            'name' => $this->faker->name,
            'name_ar' => $this->faker->text(255),
            'email' => $this->faker->unique->email,
            'private_email' => $this->faker->text(255),
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber,
            'phone2' => $this->faker->text(255),
            'address' => $this->faker->address,
            'inside_address' => $this->faker->text(255),
            'type' => 'trainer',
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'category_id' => \App\Models\Category::factory(),
            'company_id' => \App\Models\Company::factory(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
