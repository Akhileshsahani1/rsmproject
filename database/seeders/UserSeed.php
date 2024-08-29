<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);
        for ($i = 1; $i < 11; $i++) {
            $status = $i == 1 ? true : $faker->randomElement([true, false]);
            $company = $faker->company;
            $user = User::create([
                'company_name'      => $company, 
                'owner_name'        => $i == 1 ? 'Prashant Singh' : $faker->firstname().' '.$faker->lastname(),
                'email'             => $i == 1 ? 'hr.n2rtech@gmail.com' : $faker->unique()->safeEmail(),
                'email_additional'  => $faker->unique()->safeEmail(),
                'dialcode'          => $i == 1 ? '+91' : '+65',
                'phone'             => $i == 1 ? '+6568584843' : $faker->numerify('+656#######'),
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),               
                'address'           => $i == 1 ? 'F-104, C-6 Sector 7'  : $i . ' Paya Lebar Rd #03-07, Orion@Payalebar',
                'city'              => $i == 1 ? 'Noida' : $faker->randomElement(['Hougang', 'Tampines', 'Clementi', 'Yushun', 'Woodlands', 'Seletar']),
                'state'             => $i == 1 ? 'Uttar Pradesh'  : $faker->randomElement(['Central Region', 'East Region', 'North Region', 'North-East Region', 'West Region']),
                'zipcode'           => $i == 1 ? '201301' : $faker->randomElement(['40901', '40902', '40903']),
                'iso2'              => $i == 1 ? 'in' : 'sg',
                'status'            => $status,
                'website'           => $faker->url(),
                'description'       => $company.' is a leading technology company dedicated to providing innovative solutions to businesses worldwide. With a focus on cutting-edge technology and a commitment to excellence, we help our clients harness the power of digital transformation to drive growth, increase efficiency, and stay ahead of the competition.',
            ]);
        }
    }
}
