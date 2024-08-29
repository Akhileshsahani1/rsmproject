<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReferNotification;
use App\Models\Job;
use App\Models\User;
use App\Models\Area;
use App\Models\Region;
use App\Models\SubZone;
use App\Models\PreferredClassification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){


        $jobs = Job::where(['open' => true,'status' => 'approved'])->latest()->take(10)->get();

        $positions = Job::where(['open'=> true,'status'=> 'approved'])->distinct()->get(['position_name']);
        $classifications    = PreferredClassification::get();

        return view('welcome', compact('jobs','positions','classifications'));
    }

    public function recommendation(){

        $jobs = [];
        if(Auth::guard('employee')->check()){

            $user =  Auth::guard('employee')->user();
            //getting job based on user skills


            if(!empty($user->job_skill)){
                $jobs = Job::where('open', true)->where('status', 'approved')
                       ->where(function ($query) use ($user) {
                           foreach($user->job_skill as $key => $value){
                             if($key){
                                 $query->orWhere('skills_required', 'LIKE', '%' . $value . '%');
                             }else{
                                $query->where('skills_required', 'LIKE', '%' . $value . '%');
                             }
                           }
                        });

                $jobs = $jobs->latest()->take(10)->get();
            }
             //getting job based on user classification and sub_classification
            if(empty($jobs)){
                $jobs = Job::where('classification_id',$user->classification_id)->where('sub_classification_id',$user->classification_id)->where('open', true)->where('status', 'approved')->latest()->take(10)->get();
            }
             //getting job based on user sub_classification
            if(empty($jobs)){
                $jobs = Job::where('classification_id',$user->classification_id)->where('open', true)->where('status', 'approved')->latest()->take(10)->get();
            }
        }
        //getting random post job
        if(empty($jobs)){
          $jobs = Job::where('open', true)->where('status', 'approved')->inRandomOrder()->take(10)->get();
        }
        $positions = Job::where('open', true)->where('status', 'approved')->distinct()->get(['position_name']);
        $classifications    = PreferredClassification::get();

        return view('welcome', compact('jobs','positions','classifications'));
    }

    public function jobs(Request $request){
        $name               = isset($request->position_name)?$request->position_name:'';
        $address            = isset($request->address)?$request->address:'';
        $position           = isset($request->position)?$request->position:'';
        $classification     = isset($request->classification)?$request->classification:'';
        $sub_classification = isset($request->sub_classification)?$request->posisub_classificationtion:'';
        $job_type           = isset($request->job_type)?$request->job_type:'';
        //sidebar filter
        $filter_position    = isset($request->positions)?$request->positions:'';
        $filter_region      = isset($request->region)?$request->region:'';
        $filter_area      = isset($request->area)?$request->area:'';
        $filter_sub_zone      = isset($request->sub_zone)?$request->sub_zone:'';
        $filter_job_type      = isset($request->job_types)?$request->job_types:'';
        $filter_shift      = isset($request->shift)?$request->shift:'';
        $filter_career_level      = isset($request->career_level)?$request->career_level:'';
        $filter_gender      = isset($request->gender)?$request->gender:'';
        $filter_education      = isset($request->education)?$request->education:'';
        $filter_skill      = isset($request->skill)?$request->skill:'';
        $filter_salary_from      = isset($request->salary_from)?$request->salary_from:'';
        $filter_salary_upto      = isset($request->salary_upto)?$request->salary_upto:'';
        $filter_salary      = isset($request->salary)?$request->salary:'';
        $filter_time      = isset($request->time)?$request->time:'';

        $positions = Job::select('position_name', \DB::raw('count(*) as count'))->where('open', true)->where('status', 'approved')
        ->groupBy('position_name')
        ->pluck('count', 'position_name');
        $regions = Region::get();
        $areas   = Area::get();
        $sub_zones = SubZone::get();
        $position_types = Job::select('position_type', \DB::raw('count(*) as count'))->where('open', true)->where('status', 'approved')
        ->groupBy('position_type')
        ->pluck('count', 'position_type');
        $shift_types = Job::select('shift_type', \DB::raw('count(*) as count'))->where('open', true)->where('status', 'approved')
        ->groupBy('shift_type')
        ->pluck('count', 'shift_type');
        $career_levels = Job::select('career_level', \DB::raw('count(*) as count'))->where('open', true)->where('status', 'approved')
        ->groupBy('career_level')
        ->pluck('count', 'career_level');
        $educations = Job::select('education', \DB::raw('count(*) as count'))->where('open', true)->where('status', 'approved')
        ->groupBy('education')
        ->pluck('count', 'education');
        $genders = Job::select('gender', \DB::raw('count(*) as count'))->where('open', true)->where('status', 'approved')
            ->groupBy('gender')
            ->pluck('count', 'gender');
        $educations         = ['None', 'PSLE', 'GCE O-Level', 'GCE N-Level', 'GCE A-Level', 'Diploma', 'Degree'];
        $skills             = ['PHP', 'NODE', 'LARAVEL', 'JQUERY', 'REACT', 'ANGULAR', 'WORDPRESS'];

        $jobs = Job::where('open', true)->where('status', 'approved');
        if ($name) {
            $jobs = $jobs->where(function ($query) use ($name) {
                $query->where('position_name', 'LIKE', '%' . $name . '%');
                $query->orWhere('skills_required', 'LIKE', '%' . $name . '%');
            });
        }
        if ($address) {
            $jobs =  $jobs->where('location', 'LIKE', '%' . $address . '%');
        }

        if ($classification) {
            $jobs =  $jobs->where('classification_id',  $classification);
        }

        if ($classification) {
            $jobs =  $jobs->where('classification_id',  $classification);
        }
        if ($sub_classification) {
            $jobs = $jobs->where('sub_classification_id', $sub_classification);
        }
        if ($job_type) {
            $jobs = $jobs->where('position_type', $job_type);
        }
        if($filter_position){
            $jobs = $jobs->whereIn('position_name', $filter_position);
        }
        if($filter_region){
            $jobs = $jobs->whereIn('region_id', $filter_region);
        }
        if($filter_area){
            $jobs = $jobs->whereIn('area_id', $filter_area);
        }
        if($filter_sub_zone){
            $jobs = $jobs->whereIn('sub_zone_id', $filter_sub_zone);
        }
        if($filter_job_type){
            $jobs = $jobs->whereIn('position_type', $filter_job_type);
        }
        if($filter_shift){
            $jobs = $jobs->whereIn('shift_type', $filter_shift);
        }
        if($filter_career_level){
            $jobs = $jobs->whereIn('career_level', $filter_career_level);
        }
        if($filter_gender){
            $jobs = $jobs->whereIn('gender', $filter_gender);
        }
        if($filter_education){
            $jobs = $jobs->whereIn('education', $filter_education);
        }
        if($filter_skill){
            $jobs = $jobs->whereIn('skills_required', $filter_skill);
        }
        if($filter_salary_from){
            $jobs = $jobs->where('salary_from', '>=',$filter_salary_from);
        }
        if($filter_salary_upto){
            $jobs = $jobs->where('salary_upto', '<=',$filter_salary_upto);
        }
        if($filter_time == "Oldest"){
            if($filter_salary){
                if($filter_salary == "Highest"){
                    $jobs = $jobs->orderBy('salary_upto', 'desc')->paginate(12);
                }
                if($filter_salary == "Lowest"){
                    $jobs = $jobs->orderBy('salary_upto', 'asc')->paginate(12);
                }
            }else{
                $jobs = $jobs->orderBy('id', 'asc')->paginate(12);
            }

        }else{
            if($filter_salary){
                if($filter_salary == "Highest"){
                    $jobs = $jobs->orderBy('salary_upto', 'desc')->paginate(12);
                }
                if($filter_salary == "Lowest"){
                    $jobs = $jobs->orderBy('salary_upto', 'asc')->paginate(12);
                }
            }else{
                $jobs = $jobs->orderBy('id', 'desc')->paginate(12);
            }
        }



        return view('frontend.job.index',  compact('jobs','name','address','positions','regions','areas','sub_zones','position_types','shift_types','career_levels','educations','genders','educations','skills','filter_salary_from','filter_salary_upto'));

    }

    public function jobShow($id){
        $job = Job::find($id);
        $related_jobs =  Job::where('id','!=', $id)->where('classification_id',$job->classification_id)->where('sub_classification_id',$job->sub_classification_id)->where('open',1)->limit(3)->get();
        if(empty($related_jobs)){
            $related_jobs =  Job::where('id','!=', $id)->where('classification_id',$job->classification_id)->where('open',1)->limit(3)->get();
        }
        return view('frontend.job.show', compact('job','related_jobs'));

    }
    public function referFriend(Request $request){

        $job = Job::find($request->job_id);
        Notification::route('mail', $request->email)->notify(new ReferNotification( $request->message,$job));
        return redirect()->back()->with('success','Job Refer to friend Sucessfully.');
    }

    public function notificationsEmployer(){

        $notifications = auth()->user()->notifications()
        ->orderBy('read_at', 'asc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('employer.notifications',compact('notifications'));
    }

    public function employeerReadNotifications(Request $request){

        foreach (Auth::user()->unreadNotifications as $notification) {

            $notification->markAsRead();
        }
        if( $request->from == 'bell')
        return response()->json(['message' => 'notification marked successfully']);
        else
        return redirect()->back()->with('success','All Notifications marked as read');

    }

    public function employeerDeleteNotifications(){

        Auth::user()->notifications()->delete();

        return redirect()->back()->with('success','All Notifications cleared');
    }
}
