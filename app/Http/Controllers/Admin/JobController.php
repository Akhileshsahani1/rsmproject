<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplyJob;
use App\Models\Area;
use App\Models\Chat;
use App\Models\DocumentRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\User;
use App\Models\Notification;
use App\Models\PreferredClassification;
use App\Models\PreferredSubClassification;
use App\Models\Region;
use App\Models\SubZone;
use App\Models\Skill;
use App\Notifications\Employer\ApprovalNotification;
use App\Notifications\Employee\NewJobPostingNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification as EmployeeNotification;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter                 = [];
        $filter['job']          = $request->job;
        $filter['employer']     = $request->employer;
        $filter['type']         = $request->type;
        $filter['skill']        = $request->skill;
        $filter['status']       = $request->status;
        $employer               = $request->employer;

        $jobs                   = Job::query();
        $jobs                   = isset($filter['job']) ? $jobs->where('position_name', 'LIKE', '%' . $filter['job'] . '%') : $jobs;
        if(isset($filter['employer'])){
            $jobs               = $jobs->whereHas('employer',function($q) use ($employer){
                $q->where('company_name', 'LIKE', '%' . $employer . '%');
            });
        }
        $jobs                   = isset($filter['type']) ? $jobs->where('position_type', 'LIKE', '%' . Str::replace('-',' ',$filter['type']) . '%') : $jobs;
        $jobs                   = isset($filter['skill']) ? $jobs->where('skills_required', 'LIKE', '%' . $filter['skill'] . '%') : $jobs;
        $jobs                   = isset($filter['status']) ? $jobs->where('status', $filter['status']) : $jobs;

        $jobs                   = $jobs->orderBy('id', 'desc')->paginate(20);
        $employers              =  User::where('status',true)->get();

        return view('admin.jobs.list', compact('jobs', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employers          = User::where('status',true)->get();
        $educations         = ['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree'];
        // $skills             = ['PHP', 'NODE', 'LARAVEL', 'JQUERY', 'REACT', 'ANGULAR', 'WORDPRESS'];
        $working_days       = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $working_hours      = ['00:00 AM - 01:00 AM', '01:00 AM - 02:00 AM', '02:00 AM - 03:00 AM', '03:00 AM - 04:00 AM', '04:00 AM - 05:00 AM', '05:00 AM - 06:00 AM', '06:00 AM - 07:00 AM', '07:00 AM - 08:00 AM', '08:00 AM - 09:00 AM', '09:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 13:00 PM', '13:00 PM - 14:00 PM', '14:00 PM - 15:00 PM', '15:00 PM - 16:00 PM', '16:00 PM - 17:00 PM', '17:00 PM - 18:00 PM', '18:00 PM - 19:00 PM', '19:00 PM - 20:00 PM', '20:00 PM - 21:00 PM', '21:00 PM - 22:00 PM', '22:00 PM - 23:00 PM', '23:00 PM - 00:00 AM'];
        $regions            = Region::get(['id', 'name']);
        $classifications    = PreferredClassification::get();
        $skills = Skill::where('status',true)->pluck('name')->toArray();
       
        return view('admin.jobs.create', compact('employers','educations','skills', 'regions', 'classifications', 'working_days', 'working_hours'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employer'                  => ['required'],
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
            'gender'                    => ['required'],
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
            'description'               => ['required'],
            'benefits'                  => ['required'],
            'job_approved'              => ['required'],
            'job_status'                => ['required'],
        ]);

            $job                        = new Job();
            $job->employer_id           = $request->employer;
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
            $job->gender                = $request->gender;
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
            $job->status                = $request->job_approved;
            $job->open                  = $request->job_status;
            $job->save();


        $employer               = User::find($job->employer_id);
        switch (Auth::user()->role) {
            case 'Superadmin':
                $route = route('admin.superadmins.show', Auth::user()->id);
                break;
            case 'Admin':
                $route = route('admin.admins.show', Auth::user()->id);
                break;
            case 'Account User':
                $route = route('admin.account-employees.show', Auth::user()->id);
                break;
            default:
                $route = route('admin.admins.show', Auth::user()->id);
                break;
        }

        Notification::create([
            'type'          => 'New job Created',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $employer->id,
            'model'         => 'User',
            'message'       =>  'An Admin <a href='.route("admin.admins.show", $employer->id) .'>'.$employer->firstname.' '.$employer->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        foreach($request->skills as $new_skill){
           $exists = Skill::where('name',$new_skill)->exists();
           if(!$exists){
               Skill::create([
                'name' => $new_skill,
                'status' => false
               ]);
           }
        }


       return redirect()->route('admin.jobs.index', ['status' => 'approved'])->with('success', 'Job Created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $job =  Job::find($id);
         return view('admin.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $job =  Job::find($id);
         $employers =  User::where('status',true)->get();
         $educations = ['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree'];
         // $skills = ['PHP', 'NODE', 'LARAVEL', 'JQUERY', 'REACT', 'ANGULAR', 'WORDPRESS'];
         $skills = Skill::where('status',true)->pluck('name')->toArray();
         $working_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
         $working_hours = ['00:00 AM - 01:00 AM', '01:00 AM - 02:00 AM', '02:00 AM - 03:00 AM', '03:00 AM - 04:00 AM', '04:00 AM - 05:00 AM', '05:00 AM - 06:00 AM', '06:00 AM - 07:00 AM', '07:00 AM - 08:00 AM', '08:00 AM - 09:00 AM', '09:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 13:00 PM', '13:00 PM - 14:00 PM', '14:00 PM - 15:00 PM', '15:00 PM - 16:00 PM', '16:00 PM - 17:00 PM', '17:00 PM - 18:00 PM', '18:00 PM - 19:00 PM', '19:00 PM - 20:00 PM', '20:00 PM - 21:00 PM', '21:00 PM - 22:00 PM', '22:00 PM - 23:00 PM', '23:00 PM - 00:00 AM'];
         $regions = Region::get(['id','name']);
         $classifications    = PreferredClassification::get();
         if(isset($job->classification_id)){
             $subclassifications = PreferredSubClassification::where('classification_id', $job->classification_id)->get();
         }else{
             $subclassifications = [];
         }

         $areas = Area::where('region_id', $job->region_id)->get();
         $subzones = SubZone::where('area_id', $job->area_id)->get();
         return view('admin.jobs.edit', compact('job','employers','educations','skills', 'regions', 'classifications', 'subclassifications', 'working_days', 'working_hours', 'areas', 'subzones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { 
        $this->validate($request, [
            'employer'                  => ['required'],
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
            'gender'                    => ['required'],
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
            'description'               => ['required'],
            'benefits'                  => ['required'],
            'job_approved'              => ['required'],
            'job_status'                => ['required'],
        ]);

                $job                        = Job::find($id);
                $job->employer_id           = $request->employer;
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
                $job->position_type          = $request->position_type;
                $job->shift_type            = $request->shift_type;
                $job->career_level          = $request->career_level;
                $job->gender                = $request->gender;
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
                $job->status                = $request->job_approved;
                $job->open                  = $request->job_status;
                $job->save();

                $employer               = User::find($job->employer_id);
                switch (Auth::user()->role) {
                    case 'Superadmin':
                        $route = route('admin.superadmins.show', Auth::user()->id);
                        break;
                    case 'Admin':
                        $route = route('admin.admins.show', Auth::user()->id);
                        break;
                    case 'Account User':
                        $route = route('admin.account-employees.show', Auth::user()->id);
                        break;
                    default:
                        $route = route('admin.admins.show', Auth::user()->id);
                        break;
                }

                Notification::create([
                    'type'          => 'Job Updated SuccessFully.',
                    'sender'        => 'Admin',
                    'sender_id'     =>  Auth::user()->id,
                    'receiver'      => 'Superadmin',
                    'receiver_id'   => 1,
                    'model_id'      => $employer->id,
                    'model'         => 'User',
                    'message'       =>  'An Admin <a href='.route("admin.admins.show", $employer->id) .'>'.$employer->firstname.' '.$employer->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
                ]);

                 foreach($request->skills as $new_skill){
                   $exists = Skill::where('name',$new_skill)->exists();
                   if(!$exists){
                       Skill::create([
                        'name' => $new_skill,
                        'status' => false
                       ]);
                   }
                }

               return redirect()->route('admin.jobs.index', ['status' => 'approved'])->with('success', 'Job Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Job::find($id)->delete();
        Chat::where('job_id', $id)->delete();
        DocumentRequest::where('job_id', $id)->delete();
        ApplyJob::where('job_id', $id)->delete();
        JobBookmark::where('job_id', $id)->delete();
        return redirect()->route('admin.jobs.index', ['status' => 'approved'])->with('success', 'Job Deleted successfully!');
    }

    public function bulkDelete(Request $request){
          Job::whereIn('id', $request->jobs)->delete();
          return response()->json(['success' => 'Jobs deleted successfully!'], 200);
    }
    public function approvalForm($id){

         Job::find($id)->update(['status'=> 'approved']);
         $job = Job::find($id);
         if($job->skills_required){
           $employees = Employee::query();
               foreach($job->skills_required as $key => $value){
                    if($key){
                        $employees = $employees->orWhere('job_skill', 'LIKE', '%' . $value . '%');
                    }else{
                        $employees = $employees->where('job_skill', 'LIKE', '%' . $value . '%');
                    }
               }

                $employees = $employees->get();
            EmployeeNotification::send($employees, new NewJobPostingNotification($id));
         }

        User::find( Job::find($id)->employer_id )->notify( new ApprovalNotification( $id ) );
        return redirect()->route('admin.jobs.index', ['status' => 'approved'])->with('success', 'Job has been approved successfully!');
    }

    public function applicants($id){
        $job = Job::find($id);
        return view('admin.jobs.applicant', compact('job'));
    }

    public function viewApplicant($id){
        $applied_job            = ApplyJob::find($id);
        $employee               = Employee::find($applied_job->employee_id);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/employee-avatar.png') ;
        return view('admin.jobs.view-applicant', compact('employee', 'applied_job'));
    }
}
