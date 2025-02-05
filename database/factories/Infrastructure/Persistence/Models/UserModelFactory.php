<?php

namespace Database\Factories\Infrastructure\Persistence\Models;

use App\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserModel>
 */
class UserModelFactory extends Factory
{
    protected $model = UserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->generateValidFirstName($this->faker->firstName),
            'lastname' => $this->generateValidLastName($this->faker->lastName),
            'phone' => '+7' . $this->faker->numerify('##########'),
            'avatar_id' => null,
        ];

    }

    private function generateValidFirstName(string $firstname): string
    {
        if (strlen($firstname) < 4) {
            $firstname = str_pad($firstname, 4, 'a');
        }

        return substr($firstname, 0, 39);
    }

    private function generateValidLastName(string $lastname): string
    {
        if (strlen($lastname) < 4) {
            $lastname = str_pad($lastname, 4, 'a');
        }

        return substr($lastname, 0, 39);
    }
}
