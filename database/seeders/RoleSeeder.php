<?php

namespace Database\Seeders;


use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Enums\RoleType;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory(1)->setRoleType(RoleType::ADMIN)->create();
        Role::factory(1)->setRoleType(RoleType::USER)->create();
    }
}
