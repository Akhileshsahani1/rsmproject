<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator;

class EmployeeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);
        for ($i = 1; $i < 12; $i++) {
            $status = $i == 1 ? true : $faker->randomElement([true, false]);
            $employee = Employee::create([
                'firstname'             => $i == 1 ? 'Tanish' : $faker->firstname(),
                'lastname'              => $i == 1 ? 'Makan' : $faker->lastname(),
                'email'                 => $i == 1 ? 'hr.n2rtech@gmail.com' : $faker->unique()->safeEmail(),
                'email_additional'      => $faker->unique()->safeEmail(),
                'dialcode'              => $i == 1 ? '+91' : '+65',
                'phone'                 => $i == 1 ? '+6568474843' : $faker->numerify('+656#######'),
                'email_verified_at'     => now(),
                'password'              => Hash::make('password'),
                'remember_token'        => Str::random(10),
                'nationality'           => Nationality::inRandomOrder()->first()->nationality,
                'gender'                => $i == 1 ? 'Male' : $faker->randomElement(['Male', 'Female', 'Other']),
                'address'               => $i == 1 ? 'F-104, C-6 Sector 7'  : $i . ' Paya Lebar Rd #03-07, Orion@Payalebar',
                'city'                  => $i == 1 ? 'Noida' : $faker->randomElement(['Hougang', 'Tampines', 'Clementi', 'Yushun', 'Woodlands', 'Seletar']),
                'state'                 => $i == 1 ? 'Uttar Pradesh'  : $faker->randomElement(['Central Region', 'East Region', 'North Region', 'North-East Region', 'West Region']),
                'zipcode'               => $i == 1 ? '201301' : $faker->randomElement(['40901', '40902', '40903']),
                'iso2'                  => $i == 1 ? 'in' : 'sg',
                'status'                => $status,
                'classification_id'     => 1,
                'sub_classification_id' => $faker->randomElement([1, 13, 15, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 14, 12]),
                'external_link'         => 'https://n2rtechnologies.com',
                'highest_education'     => $faker->randomElement(['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree']),
                'job_skill'             => ['PHP', 'NODE', 'LARAVEL', 'JQUERY', 'REACT', 'ANGULAR', 'WORDPRESS'],               
                'profile_visibility'    => $faker->randomElement(['Show Profile', 'Hide Profile']),
                'description'           => $faker->randomElement(['Passionate and results-driven professional with a proven track record in Accounting. Adept at leveraging multiple skills to drive business growth and exceed objectives.', 'Committed to continuous learning and adapting to new challenges in dynamic environments. Seeking opportunities to contribute my skills and expertise to a forward-thinking organization.'])
            ]);
        }
    }
}
