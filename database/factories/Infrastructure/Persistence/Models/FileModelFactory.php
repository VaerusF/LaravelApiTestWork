<?php

namespace Database\Factories\Infrastructure\Persistence\Models;

use App\Infrastructure\Persistence\Models\CommentModel;
use App\Infrastructure\Persistence\Models\FileModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FileModel>
 */
class FileModelFactory extends Factory
{
    protected $model = FileModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        ];
    }
}
