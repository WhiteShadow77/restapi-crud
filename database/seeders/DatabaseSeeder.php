<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new Category_Seeder())->run();
        (new RoleSeeder())->run();
        (new AdminSeeder())->run();
        (new UserSeeder())->run();

        for ($i = 1; $i <= 3; $i++) {
            Task::factory()->create(['user_id' => $i]);
        }
    }
}
