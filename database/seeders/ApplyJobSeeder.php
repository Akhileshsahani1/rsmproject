<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Employee;
use App\Models\ApplyJob;
use App\Models\Chat;
use App\Models\Message;
use Faker\Generator;
use Illuminate\Database\Seeder;

class ApplyJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);
        $employees = Employee::take(10)->get();
        $jobs = Job::all();

        foreach ($jobs as $job) {

            foreach ($employees as $employee) {

                ApplyJob::create([
                    'employee_id'   => $employee->id,
                    'job_id'        => $job->id,
                ]);

                $chat = Chat::create([
                    'job_id'        => $job->id,
                    'employee_id'   => $employee->id,
                    'user_id'       => $job->employer_id
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => 'Hello '. $employee->firstname,
                    'sender'    => 'employer',
                    'reciever_id' => $employee->id,
                    'seen'      => true
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => 'Hi '. $job->employer->company_name,
                    'sender'    => 'employee',
                    'reciever_id' => $job->employer_id,
                    'seen'      => true
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => 'How are you ? '. $employee->firstname,
                    'sender'    => 'employer',
                    'reciever_id' => $employee->id,
                    'seen'      => true
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => 'I am fine '. $job->employer->company_name. ' Thank You!',
                    'sender'    => 'employee',
                    'reciever_id' => $job->employer_id,
                    'seen'      => true
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => 'Are you interested to join as '.$job->position_name,
                    'sender'    => 'employer',
                    'reciever_id' => $employee->id,
                    'seen'      => true
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => 'Yes I am very much interested in this job!',
                    'sender'    => 'employee',
                    'reciever_id' => $job->employer_id,
                    'seen'      => true
                ]);

                Message::create([
                    'chat_id'   => $chat->id,
                    'message'   => $faker->randomElement(['Okay '. $employee->firstname. '! Good to hear this. Let us connect over call', 'Alright Then '. $employee->firstname. '! Let us schedule a meeting for you', 'Nice '. $employee->firstname. '! We will connect shorty to discuss more things']),
                    'sender'    => 'employer',
                    'reciever_id' => $employee->id,
                    'seen'      => true
                ]);
            }
        }
    }
}
