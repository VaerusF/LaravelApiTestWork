<?php

namespace Database\Factories\Infrastructure\Persistence\Models;

use App\Infrastructure\Persistence\Models\CompanyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyModel>
 */
class CompanyModelFactory extends Factory
{
    protected $model = CompanyModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->generateValidCompanyName($this->faker->unique()->company),
            'description' => substr($this->faker->text(400), 0, rand(150, 400)),
            'logo_id' => null,
        ];
    }

    private function generateValidCompanyName(string $companyName): string
    {
        if (strlen($companyName) < 4) {
            $companyName = str_pad($companyName, 4, 'a');
        }

        return substr($companyName, 0, 39);
    }
}
