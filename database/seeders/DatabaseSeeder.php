<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingsSeeder::class,
            LocationAndLanguageSeeder::class,
            AgricultureReferenceSeeder::class,
            KnowledgeSeeder::class,
            DemoUserSeeder::class,
        ]);
    }
}
