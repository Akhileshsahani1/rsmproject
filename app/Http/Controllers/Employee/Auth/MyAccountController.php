<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $admin)
    {
        $id             = Auth::guard('employee')->id();
        $employee          = Employee::find($id);
        $employee->avatar  = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->avatar) : URL::to('assets/images/users/avatar.png') ;
        return view('employee.settings.my-account', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:employees,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:employees,phone,' . $id],
        ]);

        $employee                  = Employee::find($id);
        $employee->firstname       = $request->firstname;
        $employee->lastname        = $request->lastname;
        $employee->email           = $request->email;
        $employee->iso2            = $request->iso2;
        $employee->dialcode        = $request->dialcode;
        $employee->phone           = $request->phone;

        if($request->hasfile('avatar')){

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employee/', $name, 'public');

            if(isset($employee->avatar)){

                $path   = 'public/uploads/employee/'.$employee->avatar;

                Storage::delete($path);

            }

            $employee->avatar = $name;

        }

        $employee->save();

        return redirect()->route('employee.my-account.edit', $employee->id)->with('success', 'Account updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
