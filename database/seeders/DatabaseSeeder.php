<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(NationalitySeeder::class);
        $this->call(PreferredClassificationSeeder::class);
        $this->call(PreferredSubClassificationSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(AdminSeed::class);
        $this->call(UserSeed::class);
        $this->call(EmployeeSeed::class);
        $this->call(CompanySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(ResourceSeed::class);
        $this->call(JobSeeder::class);
        $this->call(ApplyJobSeeder::class);
        $this->call(SkillSeeder::class);
    }
}
