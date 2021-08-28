<?php

namespace Database\Factories;

use App\Models\Posting;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Posting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->numberBetween(10, 300),
            'date' => $this->faker->dateTimeInInterval('-2 month', '+2 month'),
            'description' => $this->faker->text(50),
            'user_id' => rand(1, 2)
        ];
    }
}
