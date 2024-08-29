<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobs;
use App\Models\ApplyJob;
use App\Models\DocumentRequest;
use App\Models\Employee;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\JobBookmarks;
use App\Models\User;
use App\Notifications\Employer\DocRespond;
use App\Notifications\Employer\JobStatus;
use App\Notifications\Employer\NewApplication;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:employee']);
    }
    public function applyJob(Request $request){

        $applied = new ApplyJob();
        $applied->employee_id = Auth::user()->id;
        $applied->job_id  = $request->job_id;
        $applied->save();

        $employee = User::find(Job::find($request->job_id)->employer_id);

        $employee->notify(new NewApplication( Auth::user(), $request->job_id  ));

        return Response()->json([
            'success' => 'Job Applied Successfully.',
        ]);
    }

    public function bookmark($id){

        $bookmark_exists = JobBookmark::where('job_id', $id)->where('employee_id', Auth::user()->id)->exists();

        if($bookmark_exists){
            JobBookmark::where('job_id', $id)->where('employee_id', Auth::user()->id)->delete();
        }else{
            JobBookmark::create([
                'job_id' => $id,
                'employee_id' => Auth::user()->id
            ]);
        }

        return redirect()->back();
    }

    public function getBookmarks(){
        $bookmarks = JobBookmark::where('employee_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('employee.bookmark', compact('bookmarks'));
    }

    public function appliedJobs(){
        $jobs            = ApplyJob::where('employee_id', Auth::user()->id)->where('status', 'applied')->orderBy('id', 'desc')->paginate(10);   
        return view('employee.jobs.applied', compact('jobs'));    
    }
    public function awardedJobs(){
        $jobs            = ApplyJob::where('employee_id', Auth::user()->id)->where('status', 'accepted')->orderBy('id', 'desc')->paginate(10); 
        return view('employee.jobs.awarded', compact('jobs'));        
    }
    public function rejectedJobs(){
        $jobs            = ApplyJob::where('employee_id', Auth::user()->id)->where('status', 'rejected')->orderBy('id', 'desc')->paginate(10);  
        return view('employee.jobs.rejected', compact('jobs'));       
    }

    public function cancel($id){
        ApplyJob::find($id)->delete();
        $employer = User::find( Job::find( ApplyJob::find($id)->job_id )->employer_id );
        $employer->notify(new JobStatus( Auth::user(), 'rejected') );
        return redirect()->back()->with('success', 'Application cancelled successfully');
    }

    public function acceptRequestDocument($id, $job_id){
        DocumentRequest::where('employee_id', $id)->where('job_id', $job_id)->update(['status' => 'accepted']);
        $employer = User::find( Job::find($job_id)->employer_id );
        $employer->notify( new DocRespond( Auth::user(), 'accepted'));

        return redirect()->back()->with('success', 'Document requested accepted successfully');
    }

    public function rejectRequestDocument($id, $job_id){
        DocumentRequest::where('employee_id', $id)->where('job_id', $job_id)->update(['status' => 'rejected']);
        $employer = User::find( Job::find($job_id)->employer_id );
        $employer->notify( new DocRespond( Auth::user(), 'rejected'));
        return redirect()->back()->with('success', 'Document requested rejected successfully');
    }
  
}
