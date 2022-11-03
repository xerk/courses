<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => $this->faker->randomFloat(2, 0, 9999),
            'name' => $this->faker->name,
            'documentable_type' => $this->faker->text(255),
            'documentable_id' => $this->faker->randomNumber,
            'type' => $this->faker->word,
            'documentable_type' => $this->faker->randomElement([
                \App\Models\User::class,
                \App\Models\Course::class,
                \App\Models\Lead::class,
            ]),
            'documentable_id' => function (array $item) {
                return app($item['documentable_type'])->factory();
            },
        ];
    }
}
