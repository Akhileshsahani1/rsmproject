<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'employer-approved']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      
        $closed   = Job::where('open', false)->where('employer_id', Auth::user()->id)->orderBy('id', 'desc')->count();
        $open     = Job::where(['open'=> true,'status' => 'approved'])->where('employer_id', Auth::user()->id)->orderBy('id', 'desc')->count();

        $jobs = Job::where('employer_id',Auth::user()->id)->orderBy('id', 'desc')->take(3)->get();

        return view('employer.dashboard.dashboard',compact('open','closed','jobs'));
    }
}
