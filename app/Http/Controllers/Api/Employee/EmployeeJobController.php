<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\ApplyJob;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Job;
use App\Models\JobBookmark;
use App\Models\Nationality;
use App\Models\PreferredClassification;
use App\Models\PreferredSubClassification;
use App\Models\SubZone;
use App\Models\User;
use App\Notifications\Employer\NewApplication;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EmployeeJobController extends Controller
{
    public function searchJobs(Request $request)
    {

        $name = $request->search;
        $address = $request->location;
        $id = $request->id;

        if (is_null($id)) {

            $jobs = Job::where('open', true)->with('employer', 'subzone', 'area', 'region')->where('status', 'approved');

            if ($name) {
                $jobs = $jobs->where(function ($query) use ($name) {
                    $query->where('position_name', 'LIKE', '%' . $name . '%');
                    $query->orWhere('skills_required', 'LIKE', '%' . $name . '%');
                });
            }
            if ($address) {
                $jobs =  $jobs->where('location', 'LIKE', '%' . $address . '%');
            }

            if (Auth::guard('employee')->check()) {

                $user =  Auth::guard('employee')->user();
                //getting job based on user skills


                if (!empty($user->job_skill)) {
                    $jobs = Job::where('open', true)->where('status', 'approved')
                        ->where(function ($query) use ($user) {
                            foreach ($user->job_skill as $key => $value) {
                                if ($key) {
                                    $query->orWhere('skills_required', 'LIKE', '%' . $value . '%');
                                } else {
                                    $query->where('skills_required', 'LIKE', '%' . $value . '%');
                                }
                            }
                        });

                    // $jobs = $jobs->latest()->take(10)->get();
                }
                //getting job based on user classification and sub_classification
                if (empty($jobs)) {
                    $jobs = Job::where('classification_id', $user->classification_id)
                        ->where('sub_classification_id', $user->classification_id)
                        ->where('open', true)->where('status', 'approved');
                }
                //getting job based on user sub_classification
                if (empty($jobs)) {
                    $jobs = Job::where('classification_id', $user->classification_id)
                        ->where('open', true)
                        ->where('status', 'approved');
                }
            }


            $jobs = $jobs->orderBy('id', 'desc')->paginate(12);

            if (Auth::user()) {

                foreach ($jobs as $k => $job) {

                    $check_apply  = ApplyJob::where(['employee_id' => Auth::user()->id, 'job_id' => $job->id])->first();

                    if (!empty($check_apply)) {
                        $jobs[$k]->applied = true;
                    } else {
                        $jobs[$k]->applied = false;
                    }
                    $check_bookmark = JobBookmark::where([
                        'job_id' => $job->id,
                        'employee_id' => Auth::user()->id,
                    ])->first();

                    if (!empty($check_bookmark)) {
                        $jobs[$k]->bookmark = true;
                    } else {
                        $jobs[$k]->bookmark = false;
                    }
                }
            }
        } else {
            $jobs = job::where('id', $id)->paginate(1);
        }

        if (isset($jobs)) {
            foreach ($jobs as $job) {
                if (isset($job->employer)) {
                    $job->employer->companyimage = !is_null($job->employer->avatar) ? asset('storage/uploads/employers') . '/' . $job->employer->slug . '/avatar/' . $job->employer->avatar : null;
                }
            }
        }

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function jobDetail(Request $request)
    {
        $job = Job::where('id', $request->id)->with('employer', 'subzone', 'area', 'region', 'preferredclassification', 'preferredsubclassification')->first();
        $opens = Job::where('status', 'approved')
            ->where('open', true)
            ->where('employer_id', $job->employer_id)
            ->sum('no_of_position');
        $related_jobs =  Job::where('id','!=',$request->id)->where('classification_id', $job->classification_id)->with('employer', 'subzone', 'area', 'region')->where('sub_classification_id', $job->sub_classification_id)->where('open', 1)->limit(3)->get();
        if (empty($related_jobs)) {
            $related_jobs =  Job::where('id','!=',$request->id)->where('classification_id', $job->classification_id)->with('employer', 'subzone', 'area', 'region')->where('open', 1)->limit(3)->get();
        }
        $status = 'apply';
        if (Auth::user()) {

            $check_apply  = ApplyJob::where(['employee_id' => Auth::user()->id, 'job_id' => $request->id])->first();

            if (!empty($check_apply)) {
                $job->applied = true;
                $status = $check_apply->status;
            } else {
                $job->applied = false;
            }
            $check_bookmark = JobBookmark::where([
                'job_id' => $request->id,
                'employee_id' => Auth::user()->id,
            ])->first();

            if (!empty($check_bookmark)) {
                $job->bookmark = true;
            } else {
                $job->bookmark = false;
            }
        }

        if (isset($job->employer)) {
            $job->employer->companyimage = !is_null($job->employer->avatar) ? asset('storage/uploads/employers') . '/' . $job->employer->slug . '/avatar/' . $job->employer->avatar : null;
        }

        return response()->json([
            'job' => $job,
            'opens' => $opens,
            'related' => $related_jobs,
            'status'  => $status
        ]);
    }

    public function applyJob(Request $request)
    {

        $applied = new ApplyJob();
        $applied->employee_id = Auth::user()->id;
        $applied->job_id  = $request->id;
        $applied->save();

        $employee = User::find(Job::find($request->id)->employer_id);

        $employee->notify(new NewApplication(Auth::user(), $request->id));

        return Response()->json([
            'status_code' => 200,
            'success' => 'Job Applied Successfully.',
        ]);
    }

    public function bookmarkJob(Request $request)
    {

        $bookmark_exists = JobBookmark::where('job_id', $request->id)->where('employee_id', Auth::user()->id)->exists();

        if ($bookmark_exists) {
            JobBookmark::where('job_id', $request->id)->where('employee_id', Auth::user()->id)->delete();
        } else {
            JobBookmark::create([
                'job_id' => $request->id,
                'employee_id' => Auth::user()->id
            ]);
        }

        return response()->json([
            'status_code' => 200,
            'success' => 'Job bookmarked successfully!'
        ]);
    }

    public function employeeJobs(Request $request)
    {

        $jobs  = ApplyJob::with('job', 'job.employer', 'job.subzone', 'job.area', 'job.region')->where('employee_id', Auth::user()->id)->where('status', $request->status)->orderBy('id', 'desc')->paginate(5);

        if (Auth::user()) {

            foreach ($jobs as $k => $job) {

                $check_apply  = ApplyJob::where(['employee_id' => Auth::user()->id, 'job_id' => $job->job_id])->first();

                if (!empty($check_apply)) {
                    $jobs[$k]->applied = true;
                } else {
                    $jobs[$k]->applied = false;
                }
                $check_bookmark = JobBookmark::where([
                    'job_id' => $job->job_id,
                    'employee_id' => Auth::user()->id,
                ])->first();

                if (!empty($check_bookmark)) {
                    $jobs[$k]->bookmark = true;
                } else {
                    $jobs[$k]->bookmark = false;
                }
            }
        }

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function dashboardJobs()
    {

        $awardedJobs            = ApplyJob::with('job')->where('employee_id', Auth::user()->id)->where('status', 'accepted')->count();
        $appliedJobs            = ApplyJob::with('job')->where('employee_id', Auth::user()->id)->where('status', 'applied')->count();
        $rejectedJobs           = ApplyJob::with('job')->where('employee_id', Auth::user()->id)->where('status', 'rejected')->count();

        return response()->json([
            'applied' => $appliedJobs,
            'awarded' => $awardedJobs,
            'rejected' => $rejectedJobs
        ]);
    }

    public function checkBookMark(Request $request)
    {
        $bookmark = JobBookmark::where(['job_id' => $request->id, 'employee_id' => Auth::user()->id])->first();
        if (!is_null($bookmark)) {
            return response()->json(['bookmark' => true]);
        } else {
            return response()->json(['bookmark' => false]);
        }
    }

    public function employeeBookmarkJob()
    {

        $jobs  = JobBookmark::with('job', 'job.employer', 'job.subzone', 'job.area', 'job.region')->where('employee_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(8);

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function getAwardedJobs(Request $request)
    {
        $jobs  = ApplyJob::with('job', 'job.employer', 'job.subzone', 'job.area', 'job.region')->where('employee_id', Auth::user()->id)->where('status', 'accepted')->orderBy('id', 'desc')->get();

        return response()->json([
            'jobs' => $jobs
        ]);
    }
}
