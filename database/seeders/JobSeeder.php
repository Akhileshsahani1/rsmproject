<?php

namespace Database\Seeders;

use App\Models\ApplyJob;
use App\Models\Employee;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        $employers = User::get();

        foreach ($employers as $employer) {

            $shift_type = $faker->randomElement(['First Shift (Day)', 'Second Shift (Afternoon)', 'Third Shift (Night)']);

            if($shift_type == 'First Shift (Day)'){
                $working_hours = ['06:00 AM - 07:00 AM', '07:00 AM - 08:00 AM', '08:00 AM - 09:00 AM', '09:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM'];
            }

            if($shift_type == 'Second Shift (Afternoon)'){
                $working_hours = ['12:00 PM - 13:00 PM', '13:00 PM - 14:00 PM', '14:00 PM - 15:00 PM', '15:00 PM - 16:00 PM', '16:00 PM - 17:00 PM', '17:00 PM - 18:00 PM'];
            }

            if($shift_type == 'Third Shift (Night)'){
                $working_hours = ['18:00 PM - 19:00 PM', '19:00 PM - 20:00 PM', '20:00 PM - 21:00 PM', '21:00 PM - 22:00 PM', '22:00 PM - 23:00 PM', '23:00 PM - 00:00 AM'];
            }
            for ($i=0; $i < 6; $i++) {
                $job = Job::create([
                    'employer_id'               => $employer->id,
                    'location'                  => 'Orion @ Paya Lebar, 160 Paya Lebar Rd, Singapore 409022',
                    'region_id'                 => 1,
                    'area_id'                   => 1,
                    'sub_zone_id'               => 2,
                    'latitude'                  => 1.3294848448934506,
                    'longitude'                 => 103.89022004986296,
                    'position_name'             => $faker->jobTitle,
                    'classification_id'         => 1,
                    'sub_classification_id'     => $faker->randomElement([1, 13, 15, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 14, 12]),
                    'no_of_position'            => $faker->randomElement([2, 3, 4, 5]),
                    'description'               => '<p>We are seeking a talented and creative UI/UX Designer with a strong background in mobile app design to join our team. The ideal candidate will be responsible for designing user interfaces and experiences that not only look great but also provide an intuitive and seamless interaction for our mobile applications.</p>',
                    'position_type'             => $faker->randomElement(['Part Time', 'Full Time', 'Contract']),
                    'contract_days'             => $faker->randomElement([1, 2, 3, 4, 5]),
                    'shift_type'                => $shift_type,
                    'career_level'              => $faker->randomElement(['Entry Level', 'Mid Level', 'Experienced Professional']),
                    'gender'                    => $faker->randomElement(['Male', 'Female', 'Other']),
                    'salary_type'               => $faker->randomElement(['Month Range', 'Month Fixed', 'Day Range', 'Day Fixed', 'Hourly', 'Contracted Value']),
                    'start'                     => $faker->randomElement([1, 2, 3]),
                    'end'                       => $faker->randomElement([5, 6, 7]),
                    'education'                 => $faker->randomElement(['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree']),
                    'skills_required'           => ['PHP', 'NODE', 'LARAVEL', 'JQUERY', 'REACT', 'ANGULAR', 'WORDPRESS'],
                    'working_days'              => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'working_start_hour'        => '10:00',
                    'working_end_hour'          => '19:00',
                    'salary_from'               => $faker->randomElement([1000, 2000, 3000]),
                    'salary_upto'               => $faker->randomElement([4000, 5000, 6000]),
                    'status'                    => 'approved',
                    'open'                      => $faker->randomElement([true]),
                ]);
            }

        }
    }
}
