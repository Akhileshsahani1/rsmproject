<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\ApplyJob;
use App\Models\Area;
use App\Models\DocumentRequest;
use App\Models\Employee;
use App\Models\EmployeeBookmark;
use App\Models\Job;
use App\Models\Notification;
use App\Models\PreferredClassification;
use App\Models\PreferredSubClassification;
use App\Models\Region;
use App\Models\User;
use App\Models\Skill;
use App\Models\SubZone;
use App\Notifications\Employee\DocRequest as EmployeeDocRequest;
use App\Notifications\Employee\JobStatus;
use App\Notifications\Employer\DocRequest;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function recentJobs()
    {
        $jobs = Job::where('employer_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        $jobs   = $jobs->through(function ($job) {
            return [
                'job_id'            => $job->id,
                'title'             => $job->position_name,
                'no_of_position'    => $job->no_of_position,
                'status'            => $job->open,
                'applicant'         => $job->appliedjobs->count(),
                'date_added'        => Carbon::parse($job->created_at)->format('M d,Y'),
            ];
        });
        return response()->json([
            'jobs' => $jobs
        ]);
    }
    public function allJobs(Request $request)
    {
        $jobs = Job::where('employer_id', Auth::user()->id);
        if (isset($request->filter_job_status) && $request->filter_job_status != '') {
            $jobs = $jobs->where('open', $request->filter_job_status);
        }
        $jobs = $jobs->orderBy('id', 'desc')->paginate(10);
        $jobs   = $jobs->through(function ($job) {
            return [
                'job_id'            => $job->id,
                'title'             => $job->position_name,
                'no_of_position'    => $job->no_of_position,
                'status'            => $job->open,
                'location'          => $job->location,
                'applicant'         => $job->appliedjobs->count(),
                'date_added'        => Carbon::parse($job->created_at)->format('M d,Y'),
            ];
        });
        return response()->json([
            'jobs' => $jobs
        ]);
    }
    public function viewJob($job_id)
    {

        $job = Job::find($job_id);
        $applied_count = Applyjob::where('job_id', $job_id)->where('status', 'applied')->count();
        $white_list_count = Applyjob::where('job_id', $job_id)->where('status', 'white-list')->count();
        $rejected_count = Applyjob::where('job_id', $job_id)->where('status', 'rejected')->count();

        $job   = [
            'job_id'            => $job->id,
            'title'             => $job->position_name,
        ];
        return response()->json([
            'job'              => $job,
            'applied_count'    => $applied_count,
            'white_list_count' => $white_list_count,
            'rejected_count'   => $rejected_count,
        ]);
    }
    public function closedJob($job_id)
    {

        Job::where('employer_id', Auth::user()->id)->where('id', $job_id)->update(['open' => 0]);

        return response()->json([
            'message' => 'Job Marked as Closed Successfully.',
        ]);
    }
    public function appliedApplicant($job_id)
    {
        $applicants = Applyjob::where('job_id', $job_id)->where('status', 'applied')->orderBy('updated_at', 'DESC')->paginate(10);

        $applicants   = $applicants->through(function ($e) {
            $e->employee->avatar   = isset($e->employee->avatar) ? asset('storage/uploads/employees/' . $e->employee->slug . '/avatar' . '/' . $e->employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
            return [
                'applied_id'          => $e->id,
                'employee_id'         => $e->employee->id,
                'job_id'              => $e->job_id,
                'firstname'           => $e->employee->firstname,
                'lastname'            => $e->employee->lastname,
                'avatar'              => $e->employee->avatar,
                'classification'      => $e->employee->preferredclassification->classification,
                'sub_classification'  => $e->employee->preferredsubclassification->sub_classification,
                'education'           => $e->employee->highest_education,
                'address'             => $e->employee->address,
                'city'                => $e->employee->city,
                'state'               => $e->employee->state,
                'zipcode'             => $e->employee->zipcode,
                'skills'              => $e->employee->job_skill,
                'phone'               => $e->employee->phone,
                'document'            => Helper::documentRequestExist($e->job_id, $e->employee->id),
                'bookmark_exist'      => Helper::employeeBookmarkExist($e->employee->id, Auth::user()->id),
                'applied_on'          => Carbon::parse($e->created_at)->format('M d,Y'),
            ];
        });
        return response()->json([
            'applicants' => $applicants
        ]);
    }
    public function whiteListedApplicant($job_id)
    {
        $applicants = Applyjob::where('job_id', $job_id)->where('status', 'white-list')->orderBy('updated_at', 'DESC')->paginate(10);

        $applicants   = $applicants->through(function ($e) {
            $e->employee->avatar   = isset($e->employee->avatar) ? asset('storage/uploads/employees/' . $e->employee->slug . '/avatar' . '/' . $e->employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
            return [
                'applied_id'          => $e->id,
                'employee_id'         => $e->employee->id,
                'job_id'              => $e->job_id,
                'firstname'           => $e->employee->firstname,
                'lastname'            => $e->employee->lastname,
                'avatar'              => $e->employee->avatar,
                'classification'      => $e->employee->preferredclassification->classification,
                'sub_classification'  => $e->employee->preferredsubclassification->sub_classification,
                'education'           => $e->employee->highest_education,
                'address'             => $e->employee->address,
                'city'                => $e->employee->city,
                'state'               => $e->employee->state,
                'zipcode'             => $e->employee->zipcode,
                'skills'              => $e->employee->job_skill,
                'phone'               => $e->employee->phone,
                'document'            => Helper::documentRequestExist($e->job_id, $e->employee->id),
                'bookmark_exist'      => Helper::employeeBookmarkExist($e->employee->id, Auth::user()->id),
                'applied_on'          => Carbon::parse($e->created_at)->format('M d,Y'),
            ];
        });
        return response()->json([
            'applicants' => $applicants
        ]);
    }
    public function rejectedApplicant($job_id)
    {
        $applicants = Applyjob::where('job_id', $job_id)->where('status', 'rejected')->orderBy('updated_at', 'DESC')->paginate(10);

        $applicants   = $applicants->through(function ($e) {
            $e->employee->avatar   = isset($e->employee->avatar) ? asset('storage/uploads/employees/' . $e->employee->slug . '/avatar' . '/' . $e->employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
            return [
                'applied_id'          => $e->id,
                'employee_id'         => $e->employee->id,
                'job_id'              => $e->job_id,
                'firstname'           => $e->employee->firstname,
                'lastname'            => $e->employee->lastname,
                'avatar'              => $e->employee->avatar,
                'classification'      => $e->employee->preferredclassification->classification,
                'sub_classification'  => $e->employee->preferredsubclassification->sub_classification,
                'education'           => $e->employee->highest_education,
                'address'             => $e->employee->address,
                'city'                => $e->employee->city,
                'state'               => $e->employee->state,
                'zipcode'             => $e->employee->zipcode,
                'skills'              => $e->employee->job_skill,
                'phone'               => $e->employee->phone,
                'document'            => Helper::documentRequestExist($e->job_id, $e->employee->id),
                'bookmark_exist'      => Helper::employeeBookmarkExist($e->employee->id, Auth::user()->id),
                'applied_on'          => Carbon::parse($e->created_at)->format('M d,Y'),
            ];
        });
        return response()->json([
            'applicants' => $applicants
        ]);
    }

    public function employeeBookmark($id,$type)
    {

        $bookmark_exists = EmployeeBookmark::where('employee_id', $id)->where('user_id', Auth::user()->id)->exists();

        if($bookmark_exists){
            EmployeeBookmark::where('employee_id', $id)->where('user_id', Auth::user()->id)->delete();
        }else{
            EmployeeBookmark::create([
                'employee_id' => $id,
                'user_id' => Auth::user()->id
            ]);
        }

        return response()->json([
            'message' => ($type == 'create' ) ? 'Employee Save as Bookmarked Successfully.' : 'Bookmark removed Successfully',
        ]);
    }

    public function listBookmarks(Request $request){


        $bookmarks = EmployeeBookmark::where('user_id', Auth::user()->id)->with('employee')->paginate(5);
        $bookmarks = $bookmarks->through( function($e){
            $e->employee->avatar   = isset($e->employee->avatar) ? asset('storage/uploads/employees/' . $e->employee->slug . '/avatar' . '/' . $e->employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
            return [
                        'applied_id'          => $e->employee->id,
                        'employee_id'         => $e->employee->id,
                        'firstname'           => $e->employee->firstname,
                        'lastname'            => $e->employee->lastname,
                        'avatar'              => $e->employee->avatar,
                        'classification'      => $e->employee->preferredclassification->classification,
                        'sub_classification'  => $e->employee->preferredsubclassification->sub_classification,
                        'education'           => $e->employee->highest_education,
                        'address'             => $e->employee->address,
                        'city'                => $e->employee->city,
                        'state'               => $e->employee->state,
                        'zipcode'             => $e->employee->zipcode,
                        'skills'              => $e->employee->job_skill,
                        'phone'               => $e->employee->phone,
                        'document'            => Helper::documentRequestExist($e->job_id, $e->employee->id),
                        'bookmark_exist'      => Helper::employeeBookmarkExist($e->employee->id, Auth::user()->id),
                        'applied_on'          => Carbon::parse($e->created_at)->format('M d,Y'),
                    ];

        });


        return response()->json([
            'bookmarks' => $bookmarks,
        ]);

    }

    public function employeeWhiteList($id)
    {

        Applyjob::find($id)->update(['status' => 'white-list']);

        return response()->json([
            'message' => 'Employee Save as White Listed Successfully.',
        ]);
    }

    public function employeeReject($id)
    {

        Applyjob::find($id)->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Employee rejected Successfully.',
        ]);
    }

    public function requestDocument($id, $job_id)
    {
        $exists = DocumentRequest::where('employee_id', $id)->where('job_id', $job_id)->exists();
        if ($exists) {
            $document_request = DocumentRequest::where('employee_id', $id)->where('job_id', $job_id)->first();
        } else {
            DocumentRequest::create([
                'employee_id' => $id,
                'job_id'      => $job_id
            ]);
        }
        $employee = Employee::find($id);
        //Auth::user()->notify( new DocRequest( $employee , $job_id));
        $employee->notify(new EmployeeDocRequest($job_id, 'requested'));

        return response()->json([
            'message' => 'Employee Doc Request Successfully.',
        ]);
    }

    public function document($id)
    {
        $employee = Employee::find($id);


        $storage_path = 'app/public/uploads/employees/' . $employee->slug . '/documents';
        foreach ($employee->documents as $doucment) {
            $documents[] =  $doucment->name;
        }
        $zipFileName = storage_path($storage_path . '/' . $employee->slug . '.zip');
        //    return $zipFileName;
        $zip = new ZipArchive;
        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($documents as $document) {
            $filePath = storage_path($storage_path . '/' . $document);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $document);
            }
        }

        // Close the zip archive
        $zip->close();

        // Generate response to download the zip archive
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    public function viewEmployee($employee_id, $job_id)
    {
        $applicant = Applyjob::where('job_id', $job_id)->where('employee_id', $employee_id)->first();

        $applicant   =  [
            'applied_id'          => $applicant->id,
            'employee_id'         => $applicant->employee->id,
            'job_id'              => $applicant->job_id,
            'firstname'           => $applicant->employee->firstname,
            'lastname'            => $applicant->employee->lastname,
            'classification'      => $applicant->employee->preferredclassification->classification,
            'sub_classification'  => $applicant->employee->preferredsubclassification->sub_classification,
            'education'           => $applicant->employee->highest_education,
            'address'             => $applicant->employee->address,
            'city'                => $applicant->employee->city,
            'state'               => $applicant->employee->state,
            'zipcode'             => $applicant->employee->zipcode,
            'skills'              => $applicant->employee->job_skill,
            'phone'               => $applicant->employee->phone,
            'description'         => $applicant->employee->description,
            'document'            => Helper::documentRequestExist($applicant->job_id, $applicant->employee->id),
            'bookmark_exist'      => Helper::employeeBookmarkExist($applicant->employee->id, Auth::user()->id),
            'applied_on'          => Carbon::parse($applicant->created_at)->format('M d,Y'),
        ];

        return response()->json([
            'applicant' => $applicant
        ]);
    }

    public function postJobData()
    {

        $educations         = ['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree'];
        $skills = Skill::where('status', true)->pluck('name')->toArray();
        $working_days       = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $working_hours      = ['00:00 AM - 01:00 AM', '01:00 AM - 02:00 AM', '02:00 AM - 03:00 AM', '03:00 AM - 04:00 AM', '04:00 AM - 05:00 AM', '05:00 AM - 06:00 AM', '06:00 AM - 07:00 AM', '07:00 AM - 08:00 AM', '08:00 AM - 09:00 AM', '09:00 AM - 10:00 AM', '10:00 AM - 11:00 AM', '11:00 AM - 12:00 PM', '12:00 PM - 13:00 PM', '13:00 PM - 14:00 PM', '14:00 PM - 15:00 PM', '15:00 PM - 16:00 PM', '16:00 PM - 17:00 PM', '17:00 PM - 18:00 PM', '18:00 PM - 19:00 PM', '19:00 PM - 20:00 PM', '20:00 PM - 21:00 PM', '21:00 PM - 22:00 PM', '22:00 PM - 23:00 PM', '23:00 PM - 00:00 AM'];
        $regions            = Region::get(['id', 'name']);
        $classifications    = PreferredClassification::get();

        return response()->json([
            'educations' => $educations,
            'skills'  => $skills,
            'working_days' => $working_days,
            'working_hours' => $working_hours,
            'regions'   => $regions,
            'classifications' => $classifications
        ]);
    }

    public function getSubClassification(Request $request)
    {
        $subclassifications = PreferredSubClassification::where('classification_id', $request->classification_id)->get();

        $output = [];
        if (isset($subclassifications)) :
            foreach ($subclassifications as $subclassification) {
                $output[] =  [
                    "id" => $subclassification->id,
                    "sub_classification" =>  $subclassification->sub_classification
                ];
            }
        endif;
        return response()->json([
            'subclassification' => $output
        ]);
    }

    public function getAreas(Request $request)
    {

        $areas = Area::where('region_id', $request->region_id)->get();

        $area = [];

        if (isset($areas)) :
            foreach ($areas as $_area) {
                $area[] = ['id' => $_area->id, 'area' => $_area->name];
            }
        endif;

        return response()->json([
            'areas' => $area
        ]);
    }

    public function getSubzones(Request $request)
    {

        $subzones = SubZone::where('area_id', $request->area_id)->get();
        $subzone = [];

        if (isset($subzones)) :
            foreach ($subzones as $_subzone) {
                $subzone[] = ['id' => $_subzone->id, 'name' =>  $_subzone->name];
            }
        endif;

        return response()->json([
            'subzones' => $subzone
        ]);
    }

    public function postJob(Request $request)
    {

        $id = Auth::user()->id;

        $validate = Validator::make($request->all(), [

            'position_name'             => ['required', 'string', 'max:255'],
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
            // 'gender'                    => ['required'],
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
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->messages()]);
        }



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

        $admins = Administrator::where('status', 1)->get();

        if (isset($admins)) {
            foreach ($admins as $admin) {
                $args = [
                    'type'          => 'New job posted',
                    'sender'        => 'Employee',
                    'sender_id'     =>  $id,
                    'receiver'      => 'Admin',
                    'receiver_id'   =>  $admin->id,
                    'model_id'      =>  $admin->id,
                    'model'         => 'Administrator',
                    'message'       =>  'A new  <a href=' . route("admin.jobs.index", ['status' => 'pending']) . '>job(' . $job->id . ')</a> has been posted by <a href=' . route("admin.employers.index", ['email' => $user->email]) . '>' . $user->owner_name . '</a>',
                ];

                Notification::create($args);
            }
        }
        foreach ($request->skills as $new_skill) {
            $exists = Skill::where('name', $new_skill)->exists();
            if (!$exists) {
                Skill::create([
                    'name' => $new_skill,
                    'status' => false
                ]);
            }
        }

        return response()->json(['message' => 'Job has been created successfully but Pending for approval from administrator!']);
    }
}
