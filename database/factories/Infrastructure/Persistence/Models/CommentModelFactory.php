<?php

namespace Database\Factories\Infrastructure\Persistence\Models;

use App\Infrastructure\Persistence\Models\CommentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommentModel>
 */
class CommentModelFactory extends Factory
{
    protected $model = CommentModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'company_id' => $this->faker->numberBetween(1, 25),
            'rating' => $this->faker->numberBetween(1, 10),
            'content' => substr($this->faker->text(550), 0, rand(150, 550)),
        ];
    }
}
