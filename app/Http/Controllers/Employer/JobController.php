<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\ApplyJob;
use App\Models\DocumentRequest;
use App\Models\Employee;
use App\Models\EmployeeBookmark;
use App\Models\Job;
use App\Models\Notification;
use App\Models\PreferredClassification;
use App\Models\Region;
use App\Models\User;
use App\Models\Skill;
use App\Notifications\Employee\DocRequest as EmployeeDocRequest;
use App\Notifications\Employee\JobStatus;
use App\Notifications\Employer\DocRequest;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use ZipArchive;
use File;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'employer-approved']);
    }

    public function index(){

        $educations         = ['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree'];
        $skills = Skill::where('status',true)->pluck('name')->toArray();
        $working_days       = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $working_hours      = ['00:00 AM - 01:00 AM', '01:00 AM - 02:00 AM', '02:00 AM - 03:00 AM', '03:00 AM - 04:00 AM', '04:00 AM - 05:00 AM', '05:00 AM - 06:00 AM', '06:00 AM - 07:00 AM', '07:00 AM - 08:00 AM', '08:00 AM - 09:00 AM', '09:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 13:00 PM', '13:00 PM - 14:00 PM', '14:00 PM - 15:00 PM', '15:00 PM - 16:00 PM', '16:00 PM - 17:00 PM', '17:00 PM - 18:00 PM', '18:00 PM - 19:00 PM', '19:00 PM - 20:00 PM', '20:00 PM - 21:00 PM', '21:00 PM - 22:00 PM', '22:00 PM - 23:00 PM', '23:00 PM - 00:00 AM'];
        $regions            = Region::get(['id', 'name']);
        $classifications    = PreferredClassification::get();
        return view('employer.post-job', compact('educations','skills', 'regions', 'classifications', 'working_days', 'working_hours'));

    }

    public function postJob(Request $request){
        $id = Auth::user()->id;


        $this->validate($request, [
            'position_name'             => ['required', 'string','max:255'],
            'preferred_classification'  => ['required'],
            'sub_classification'        => ['required'],
            'no_of_position'            => ['required'],
            'position_type'             => ['required'],
            'contract_days'             => $request->position_type == 'Contract' ? ['required'] : [],
            'shift_type'                => ['required'],
            'salary_type'               => ['required'],
            'start'                     => $request->salary_type == 'Month Range' || $request->salary_type == 'Day Range' ? ['required'] : [],
            'end'                       => $request->salary_type == 'Month Range' || $request->salary_type == 'Day Range' ? ['required'] : [],
            'career_level'              => ['required'],
            'location'                  => ['required'],
            'region'                    => ['required'],
            'area'                      => ['required'],
            'subzone'                   => ['required'],
            'education'                 => ['required'],
            'skills'                    => ['required', 'array', 'min:1'],
            'salary_from'               => ['required', 'numeric'],
            'salary_upto'               => ['required', 'numeric', 'gte:salary_from'],
            'working_days'              => ['required', 'array', 'min:1'],
            'working_start_hour'        => ['required'],
            'working_end_hour'          => ['required'],
            'description'               => ['required','min:100'],
            'benefits'                  => ['required','min:100'],
        ]);



            $job                        = new Job();
            $job->employer_id           = $id;
            $job->position_name         = $request->position_name;
            $job->classification_id     = $request->preferred_classification;
            $job->sub_classification_id = $request->sub_classification;
            $job->location              = $request->location;
            $job->region_id             = $request->region;
            $job->area_id               = $request->area;
            $job->sub_zone_id           = $request->subzone;
            $job->latitude              = $request->latitude;
            $job->longitude             = $request->longitude;
            $job->no_of_position        = $request->no_of_position;
            $job->description           = $request->description;
            $job->benefits              = $request->benefits;
            $job->position_type         = $request->position_type;
            $job->shift_type            = $request->shift_type;
            $job->career_level          = $request->career_level;
            // $job->gender                = $request->gender;
            $job->contract_days         = $request->contract_days;
            $job->salary_type           = $request->salary_type;
            $job->start                 = $request->start;
            $job->end                   = $request->end;
            $job->education             = $request->education;
            $job->skills_required       = $request->skills;
            $job->working_days          = $request->working_days;
            $job->working_start_hour    = $request->working_start_hour;
            $job->working_end_hour      = $request->working_end_hour;
            $job->salary_from           = $request->salary_from;
            $job->salary_upto           = $request->salary_upto;
            $job->hide_salary           = $request->hide_salary;
            $job->status                = 'pending';
            $job->open                  = true;
            $job->save();

            $user = User::find($id);

            $admins = Administrator::where('status',1)->get();

            if( isset($admins) ){
                foreach($admins as $admin){
                    $args = [
                        'type'          => 'New job posted',
                        'sender'        => 'Employee',
                        'sender_id'     =>  $id,
                        'receiver'      => 'Admin',
                        'receiver_id'   =>  $admin->id,
                        'model_id'      =>  $admin->id,
                        'model'         => 'Administrator',
                        'message'       =>  'A new  <a href='.route("admin.jobs.index",['status'=>'pending']) .'>job('.$job->id.')</a> has been posted by <a href='.route("admin.employers.index",['email' => $user->email]) .'>'.$user->owner_name.'</a>',
                    ];

                    Notification::create($args);

                }
            }
        foreach($request->skills as $new_skill){
           $exists = Skill::where('name',$new_skill)->exists();
           if(!$exists){
               Skill::create([
                'name' => $new_skill,
                'status' => false
               ]);
           }
        }

       return redirect()->route('home', ['open' => true])->with('success', 'Job has been created successfully but Pending for approval from administrator!');
    }

    public function openJobs(){
        $jobs = Job::where(['open' => true])->where('employer_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        return view('employer.jobs.open-jobs', compact('jobs'));
    }

    public function closedJobs(){
        $jobs = Job::where('open', false)->where('employer_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(20);
        return view('employer.jobs.closed-jobs', compact('jobs'));
    }

    public function applicants($id){
        $job = Job::find($id);
        return view('employer.jobs.applicant', compact('job'));
    }

    public function viewApplicant($id){
        $applied_job            = ApplyJob::find($id);
        $employee               = Employee::find($applied_job->employee_id);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/employee-avatar.png') ;
        return view('employer.jobs.view-applicant', compact('employee', 'applied_job'));
    }
     public function viewBookmarkApplicant($id){


        $employee               = Employee::find($id);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/employee-avatar.png') ;
        return view('employer.view-bookmark-employee', compact('employee'));
    }

    // public function contact(){
    //     return view('employer.jobs.contact');
    // }

    public function accept($id){
        $application = ApplyJob::find($id);

        $job = Job::find($application->job_id);

        $accepted_application = Applyjob::where('job_id', $application->job_id)->where('status', 'accepted')->count();

        if($accepted_application == $job->no_of_position){
            return redirect()->back()->with('warning', 'All Openings for this Job has been occupied already!');
        }else{
            ApplyJob::find($id)->update(['status'=> 'accepted']);

            Employee::find( $application->employee_id )->notify(new JobStatus( $application->job_id, 'accepted'));

            $current_count = Applyjob::where('job_id', $application->job_id)->where('status', 'accepted')->count();
            if($current_count == $job->no_of_position ){
                Job::find($application->job_id)->update(['open' => false]);
                return redirect()->route('closed-jobs')->with('success', 'Application has been accepted for the job and job has been closed successfully');
            }
            return redirect()->back()->with('success', 'Application has been accepted for the job successfully!');
        }



    }

    public function reject($id){
        $application = ApplyJob::find($id);
        ApplyJob::find($id)->update(['status'=> 'rejected']);
        Employee::find( $application->employee_id )->notify(new JobStatus( $application->job_id, 'rejected'));
        return redirect()->back()->with('error', 'Application has been rejected for the job successfully!');
    }

    public function bookmark($id){

        $bookmark_exists = EmployeeBookmark::where('employee_id', $id)->where('user_id', Auth::user()->id)->exists();

        if($bookmark_exists){
            EmployeeBookmark::where('employee_id', $id)->where('user_id', Auth::user()->id)->delete();
        }else{
            EmployeeBookmark::create([
                'employee_id' => $id,
                'user_id' => Auth::user()->id
            ]);
        }

        return redirect()->back();
    }

    public function getBookmarks(){
        $bookmarks = EmployeeBookmark::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('employer.bookmark', compact('bookmarks'));
    }

    public function requestDocument($id, $job_id){
        $exists = DocumentRequest::where('employee_id', $id)->where('job_id', $job_id)->exists();
        if($exists){
            $document_request = DocumentRequest::where('employee_id', $id)->where('job_id', $job_id)->first();
        }else{
            DocumentRequest::create([
                'employee_id' => $id,
                'job_id'      => $job_id
            ]);
        }
        $employee = Employee::find($id);
        //Auth::user()->notify( new DocRequest( $employee , $job_id));
        $employee->notify( new EmployeeDocRequest( $job_id, 'requested'));

        return redirect()->back()->with('success', 'Document requested successfully');
    }
    public function document($id){
        $employee = Employee::find($id);


        $storage_path = 'app/public/uploads/employees/'.$employee->slug.'/documents';
        foreach($employee->documents as $doucment){
            $documents[] =  $doucment->name ;
        }
        $zipFileName = storage_path($storage_path.'/'.$employee->slug.'.zip');
    //    return $zipFileName;
        $zip = new ZipArchive;
        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($documents as $document) {
            $filePath = storage_path($storage_path . '/' .$document);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $document);
            }
        }

        // Close the zip archive
        $zip->close();

        // Generate response to download the zip archive
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    public function edit($id){

        $job = Job::find($id);
        $educations         = ['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree'];
        $skills = Skill::where('status',true)->pluck('name')->toArray();
        $working_days       = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $working_hours      = ['00:00 AM - 01:00 AM', '01:00 AM - 02:00 AM', '02:00 AM - 03:00 AM', '03:00 AM - 04:00 AM', '04:00 AM - 05:00 AM', '05:00 AM - 06:00 AM', '06:00 AM - 07:00 AM', '07:00 AM - 08:00 AM', '08:00 AM - 09:00 AM', '09:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 13:00 PM', '13:00 PM - 14:00 PM', '14:00 PM - 15:00 PM', '15:00 PM - 16:00 PM', '16:00 PM - 17:00 PM', '17:00 PM - 18:00 PM', '18:00 PM - 19:00 PM', '19:00 PM - 20:00 PM', '20:00 PM - 21:00 PM', '21:00 PM - 22:00 PM', '22:00 PM - 23:00 PM', '23:00 PM - 00:00 AM'];
        $regions            = Region::get(['id', 'name']);
        $classifications    = PreferredClassification::get();
        //dd($job);
        return view('employer.edit-job', compact('job','educations','skills', 'regions', 'classifications', 'working_days', 'working_hours'));
    }
    public function updateJob(Request $request,$id){

        $this->validate($request, [
            'position_name'             => ['required', 'string','max:255'],
            'preferred_classification'  => ['required'],
            'sub_classification'        => ['required'],
            'no_of_position'            => ['required'],
            'position_type'             => ['required'],
            'contract_days'             => $request->position_type == 'Contract' ? ['required'] : [],
            'shift_type'                => ['required'],
            'salary_type'               => ['required'],
            'start'                     => $request->salary_type == 'Month Range' || $request->salary_type == 'Day Range' ? ['required'] : [],
            'end'                       => $request->salary_type == 'Month Range' || $request->salary_type == 'Day Range' ? ['required'] : [],
            'career_level'              => ['required'],
            'location'                  => ['required'],
            'region'                    => ['required'],
            'area'                      => ['required'],
            'subzone'                   => ['required'],
            'education'                 => ['required'],
            'skills'                    => ['required', 'array', 'min:1'],
            'salary_from'               => ['required', 'numeric'],
            'salary_upto'               => ['required', 'numeric', 'gte:salary_from'],
            'working_days'              => ['required', 'array', 'min:1'],
            'working_start_hour'        => ['required'],
            'working_end_hour'          => ['required'],
            'description'               => ['required','min:100'],
            'benefits'                  => ['required','min:100'],
        ]);

            $job                        = Job::find($id);
            $job->position_name         = $request->position_name;
            $job->classification_id     = $request->preferred_classification;
            $job->sub_classification_id = $request->sub_classification;
            $job->location              = $request->location;
            $job->region_id             = $request->region;
            $job->area_id               = $request->area;
            $job->sub_zone_id           = $request->subzone;
            $job->latitude              = $request->latitude;
            $job->longitude             = $request->longitude;
            $job->no_of_position        = $request->no_of_position;
            $job->description           = $request->description;
            $job->benefits              = $request->benefits;
            $job->position_type         = $request->position_type;
            $job->shift_type            = $request->shift_type;
            $job->career_level          = $request->career_level;
            // $job->gender                = $request->gender;
            $job->contract_days         = $request->contract_days;
            $job->salary_type           = $request->salary_type;
            $job->start                 = $request->start;
            $job->end                   = $request->end;
            $job->education             = $request->education;
            $job->skills_required       = $request->skills;
            $job->working_days          = $request->working_days;
            $job->working_start_hour    = $request->working_start_hour;
            $job->working_end_hour      = $request->working_end_hour;
            $job->salary_from           = $request->salary_from;
            $job->salary_upto           = $request->salary_upto;
            $job->hide_salary           = $request->hide_salary;
            // $job->status                = 'pending';
            // $job->open                  = true;
            $job->save();

            return redirect()->route('open-jobs', ['open' => true])->with('success', 'Job has been updated successfully but Pending for approval from administrator!');
    }
}
