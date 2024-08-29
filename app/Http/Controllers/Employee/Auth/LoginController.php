<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:employee')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        if(isset($request->job_id)){
            Session::put('job_id', $request->job_id);
            return view('employee.auth.login')->with('warning','You Must Login to apply for Jobs.');
        }

        return view('employee.auth.login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email'         => 'required|email',
            'password'      => 'required|min:6'
        ]);


        if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (Auth::guard('employee')->user()->status != true) {
                Auth::guard('employee')->logout();

                return redirect()->back()->withErrors(['status' => 'Your account has been disabled. Please contact administrator'])->withInput();
            }else if(Session::has('job_id')){
                $job_id = Session::get('job_id');
                Session::forget('job_id');
                return redirect()->route('frontend.job.show',$job_id);
            }else{
                return redirect()->route('employee.dashboard');
            }

        } else {

            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        if (Auth::guard('employee')->check())
        {
            Auth::guard('employee')->logout();
            return redirect()->route('employee.login');
        }
    }
}
