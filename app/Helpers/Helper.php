<?php

namespace App\Helpers;

use App\Models\Administrator;
use App\Models\CompanySetting;
use App\Models\Country;
use App\Models\DocumentRequest;
use App\Models\Driver;
use App\Models\EmployeeBookmark;
use App\Models\Invoice;
use App\Models\Quickbook;
use App\Models\SubService;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\Chat;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;

class Helper
{

    public static function getlogo()
    {
        // $logo_exists = CompanySetting::where('id', 1)->exists();

        // if ($logo_exists) {
        //     $company =  CompanySetting::where('id', 1)->first();
        //     if (isset($company->logo)) {
        //         return URL::asset('storage/uploads/company/' . $company->logo);
        //     } else {
        //         return URL::asset('assets/images/logo.png');
        //     }
        // } else {
        //     return URL::asset('assets/images/logo.png');
        // }
        return URL::asset('assets/images/logo.gif');
    }
    public static function getJobByEducations($name){

        return Job::where('education','LIKE', '%' . $name . '%')->where('open', true)->where('status', 'approved')->count();
    }
    public static function getJobBySkills($name){

        return Job::where('skills_required','LIKE', '%' . $name . '%')->where('open', true)->where('status', 'approved')->count();
    }

    public static function bookmarkExist($id, $employee_id)
    {
        $exists = JobBookmark::where('job_id', $id)->where('employee_id', $employee_id)->exists();
        return $exists;

    }

    public static function employeeBookmarkExist($id, $employer_id)
    {
        $exists = EmployeeBookmark::where('employee_id', $id)->where('user_id', $employer_id)->exists();
        return $exists;

    }

    public static function documentRequestExist($id, $employee_id)
    {
        $exists = DocumentRequest::where('employee_id', $employee_id)->where('job_id', $id)->first();
        return $exists;
    }

    public static function documentRequestStatus($id, $employee_id)
    {
        $status = DocumentRequest::where('employee_id', $employee_id)->where('job_id', $id)->first()->status;
        return $status;
    }

    public static function checkTime($currentDateTime){
        if ($currentDateTime->isToday()) {
            return  $currentDateTime->format('h:i');
        } elseif ($currentDateTime->isYesterday()) {
            return "yesterday";
        } elseif($currentDateTime->isLastWeek()){
            return  $currentDateTime->format('D');
        }else {
            return  $currentDateTime->format('d-m-Y');
        }
    }
    public static function recentMessage($job_id){
       $chat =  Chat::where('job_id', $job_id)->latest('updated_at')->first();
       $message=[];
       if($chat){
        $message =  Message::where('chat_id', $chat->id)->latest()->first();
       }

        return $message;

    }

    public static function headNotifications(){

        if( !is_null( auth()->user() ) ):

            $notifications = auth()->user()->notifications()
            ->where('read_at',null)
            ->orderBy('read_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

            return $notifications;
        else:
            return [];
        endif;

    }

    public static function headEmployeeNotifications(){

        if( !is_null( auth()->guard('employee')->user() ) ):

            $notifications = auth()->guard('employee')->user()->notifications()
            ->where('read_at',null)
            ->orderBy('read_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();
             
            return $notifications;
        else:
            return [];
        endif;

    }


}
