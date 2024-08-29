<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = ['PHP', 'NODE', 'LARAVEL', 'JQUERY', 'REACT', 'ANGULAR', 'WORDPRESS'];
        foreach ($skills as $value) {
        	Skill::create(['name' => $value]);
        }
    }
}
