<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Administrator;
use Illuminate\Support\Str;
use Faker\Generator;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        Administrator::create( [
            'firstname'         => 'Lin',
            'lastname'          => 'Wei',
            'email'             => 'superadmin@admin.com',
            'dialcode'          => '+65',
            'phone'             => '+6587767705',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'Superadmin',
            'gender'            => 'Male',
            'address'           => '160 Paya Lebar Rd #03-07 Orion@Payalebar',             
            'city'              => 'Payalebar',
            'zipcode'           => '409022',
            'state'             => 'East Region',
            'iso2'              => 'sg',
            'remember_token'    => Str::random(10),
        ]);

        for ($i = 1; $i < 21; $i++) {
            $admin = Administrator::create([
                'firstname'         => $i == 1 ? 'Prashant': $faker->firstname(),
                'lastname'          => $i == 1 ? 'Singh': $faker->lastname(),
                'email'             => $i == 1 ? 'admin@admin.com' : $faker->unique()->safeEmail(),
                'dialcode'          => '+65',
                'phone'             => $faker->numerify('+658#7##70#'),
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'Admin',
                'gender'            => 'Male',
                'address'           => '160 Paya Lebar Rd #03-07 Orion@Payalebar',             
                'city'              => 'Payalebar',
                'zipcode'           => '409022',
                'state'             => 'East Region',
                'iso2'              => 'sg',
                'remember_token'    => Str::random(10),
            ]);
        }
    }
}
