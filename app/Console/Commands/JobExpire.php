<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\User;
use App\Notifications\Employer\JobClosed;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class JobExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:job-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Job expire after 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = \Carbon\Carbon::today()->subDays(30);

        $jobs  = Job::where('open',1)
                     ->where('created_at', '>',$date)
                     ->get();

        if( isset($jobs) ){
          foreach( $jobs as $job){
           Job::where('id',$job->id)->update(['open'=>0]);
           User::find($job->employer_id)->notify( new JobClosed( $job->id ));
          }
        }
    }
}
