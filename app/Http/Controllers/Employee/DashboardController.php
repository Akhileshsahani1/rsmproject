<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:employee']);
    }

    public function index(Request $request)
    {
        $applied = Job::with('applies');
        $applied = $applied->whereHas('applies',function($q){
            return $q->where([
                'employee_id' => Auth::user()->id,
                'status' => 'applied'
            ]);
        });
        $applied =  $applied->count();

        $awarded = Job::with('applies');
        $awarded = $awarded->whereHas('applies',function($q){
            return $q->where([
                'employee_id' => Auth::user()->id,
                'status' => 'accepted'
            ]);
        });
        $awarded =  $awarded->get();

        $rejected = Job::with('applies');
        $rejected = $rejected->whereHas('applies',function($q){
            return $q->where([
                'employee_id' => Auth::user()->id,
                'status' => 'rejected'
            ]);
        });
        $rejected =  $rejected->count();
        
        return view('employee.dashboard.dashboard',compact('applied','awarded','rejected'));
    }

    public function notificationsEmployee(){

        $notifications = auth()->guard('employee')->user()->notifications()
        ->orderBy('read_at', 'asc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('employee.notifications',compact('notifications'));
    }

    public function employeeReadNotifications(Request $request){
    
        foreach (Auth::guard('employee')->user()->unreadNotifications as $notification) {

            $notification->markAsRead();
        }
        if( $request->from == 'bell')
        return response()->json(['message' => 'notification marked successfully']);
        else 
        return redirect()->back()->with('success','All Notifications marked as read');

    }
    
    public function emloyeeDeleteNotifications(){

        Auth::guard('employee')->user()->notifications()->delete();

        return redirect()->back()->with('success','All Notifications cleared');
    }
}
