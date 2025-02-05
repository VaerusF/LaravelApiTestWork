<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Models\CommentModel;
use App\Infrastructure\Persistence\Models\CompanyModel;
use App\Infrastructure\Persistence\Models\FileModel;
use App\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        FileModel::factory()->create(['file_type' => 'Avatar', 'file_name' => '67a276d47fe2f.jpg']);
        FileModel::factory()->create(['file_type' => 'Avatar', 'file_name' => '67a276dcb18fc.png']);
        FileModel::factory()->create(['file_type' => 'Avatar', 'file_name' => '67a276e158d39.jpg']);

        FileModel::factory()->create(['file_type' => 'CompanyLogo', 'file_name' => '67a276d47fe2f.png']);
        FileModel::factory()->create(['file_type' => 'CompanyLogo', 'file_name' => '67a276dcb18fc.png']);
        FileModel::factory()->create(['file_type' => 'CompanyLogo', 'file_name' => '67a276e158d39.png']);

        UserModel::factory()->create(['avatar_id' => 1]);
        UserModel::factory()->create(['avatar_id' => 2]);
        UserModel::factory()->create(['avatar_id' => 3]);
        UserModel::factory(7)->create();

        CompanyModel::factory()->create(['logo_id' => 4]);
        CompanyModel::factory()->create(['logo_id' => 5]);
        CompanyModel::factory()->create(['logo_id' => 6]);
        CompanyModel::factory(22)->create();


        $users = UserModel::take(10)->get();
        $companies = CompanyModel::take(25)->get();

        foreach ($users as $user) {
            foreach ($companies as $company) {
                CommentModel::factory()->create([
                    'user_id' => $user->user_id,
                    'company_id' => $company->company_id,
                ]);
            }
        }
    }
}
