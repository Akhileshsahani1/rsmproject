<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Employee\ApprovalNotification;
use App\Models\EmployeeDocument;
use App\Models\Nationality;
use App\Models\PreferredClassification;
use App\Models\PreferredSubClassification;

class EmployeeController extends Controller
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
        $filter['name']         = $request->name;
        $filter['email']        = $request->email;
        $filter['phone']        = $request->phone;
        $filter['type']         = $request->type;
        $filter['status']       = $request->status;

        $employees              = Employee::query();
        $employees              = isset($filter['name']) ? $employees->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $employees;
        $employees              = isset($filter['email']) ? $employees->where('email', 'LIKE', '%' . $filter['email'] . '%') : $employees;
        $employees              = isset($filter['phone']) ? $employees->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $employees;
        $employees              = isset($filter['status']) ? $employees->where('status', $filter['status']) : $employees;

        $employees              = $employees->orderBy('id', 'desc')->paginate(20);

        return view('admin.employees.list', compact('employees', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classifications    = PreferredClassification::get();
        $nationalities      = Nationality::get(['nationality']);
        return view('admin.employees.create', compact('classifications', 'nationalities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'firstname'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'phone'                 => ['required', 'min:8', 'unique:employees'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'preferred_classification'     => ['required'],
            'sub_classification' => ['required'],
            'nationality'           => ['required'],
            'highest_education'     => ['required'],
            'job_skills'            => ['required','array', 'min:1'],
        ]);

        $employee                       = new Employee();
        $employee->firstname            = $request->firstname;
        $employee->lastname             = $request->lastname;
        $employee->email                = $request->email;
        $employee->email_additional     = $request->email_additional;
        $employee->password             = Hash::make($request->password);
        $employee->dialcode             = $request->dialcode;
        $employee->phone                = $request->phone;
        $employee->gender               = $request->gender;
        $employee->address              = $request->address;
        $employee->city                 = $request->city;
        $employee->state                = $request->state;
        $employee->zipcode              = $request->zipcode;
        $employee->iso2                 = $request->iso2;
        $employee->classification_id    = $request->preferred_classification;
        $employee->sub_classification_id = $request->sub_classification;
        $employee->nationality          = $request->nationality;
        $employee->external_link        = $request->external_link;
        $employee->highest_education    = $request->highest_education;
        $employee->job_skill            = $request->job_skills;
        $employee->description          = $request->description;
        $employee->status               = true;
        $employee->email_verified_at    = now();
        $employee->save();
        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employees/'.$employee->slug.'/'.'avatar', $name, 'public');

            Employee::find($employee->id)->update(['avatar' => $name]);
        }


        if($request->hasfile('documents'))
        {
           foreach($request->file('documents') as $file)
           {
               $document_name =  $file->getClientOriginalName();
               $file->storeAs('uploads/employees/'.$employee->slug.'/'.'documents/', $document_name, 'public');
               EmployeeDocument::create([
                   'employee_id' => $employee->id,
                   'name'     => $document_name
               ]);
           }
        }



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
            'type'          => 'Employee added',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $employee->id,
            'model'         => 'User',
            'message'       =>  'An Employee <a href='.route("admin.employees.show", $employee->id) .'>'.$employee->firstname.' '.$employee->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);


        return redirect()->route('admin.employees.index', ['status' => true])->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee          = Employee::find($id);
        $employee->avatar  = isset($employee->avatar) ? asset('storage/uploads/employees/' . $employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/avatar.png');
        $employee->country = Country::where('code', $employee->iso2)->first()->name;
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee           = Employee::find($id);
        $employee->avatar  = isset($employee->avatar) ? asset('storage/uploads/employees/' . $employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/avatar.png');
        $classifications    = PreferredClassification::get();
        $subclassifications = PreferredSubClassification::where('classification_id', $employee->classification_id)->get();
        $nationalities      = Nationality::get(['nationality']);
        return view('admin.employees.edit', compact('employee', 'classifications', 'nationalities', 'subclassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:employees,email,' . $id],
            'phone'                 => ['required', 'min:8', 'unique:employees,phone,' . $id],
            'preferred_classification'     => ['required'],
            'sub_classification' => ['required'],
            'nationality'           => ['required'],
            'highest_education'     => ['required'],
            'job_skills'            => ['required','array', 'min:1'],
        ]);

        $employee                       = Employee::find($id);
        $employee->firstname            = $request->firstname;
        $employee->lastname             = $request->lastname;
        $employee->email                = $request->email;
        $employee->email_additional     = $request->email_additional;
        $employee->dialcode             = $request->dialcode;
        $employee->phone                = $request->phone;
        $employee->gender               = $request->gender;
        $employee->address              = $request->address;
        $employee->city                 = $request->city;
        $employee->state                = $request->state;
        $employee->zipcode              = $request->zipcode;
        $employee->iso2                 = $request->iso2;
        $employee->classification_id    = $request->preferred_classification;
        $employee->sub_classification_id = $request->sub_classification;
        $employee->nationality          = $request->nationality;
        $employee->external_link        = $request->external_link;
        $employee->highest_education    = $request->highest_education;
        $employee->job_skill            = $request->job_skills;
        $employee->description          = $request->description;

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employees/'.$employee->slug.'/'.'avatar', $name, 'public');

            if (isset($employee->avatar)) {

                $path   = 'public/uploads/employees/'.$employee->slug.'/'.'avatar/'. $employee->avatar;

                Storage::delete($path);
            }

            $employee->avatar = $name;
        }

        $employee->save();

        if($request->hasfile('documents'))
        {
           foreach($request->file('documents') as $file)
           {
               $document_name =  $file->getClientOriginalName();
               $file->storeAs('uploads/employees/'.$employee->slug.'/'.'documents/', $document_name, 'public');
               EmployeeDocument::create([
                   'employee_id' => $employee->id,
                   'name'     => $document_name
               ]);
           }
        }

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
            'type'          => 'Employee updated',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $employee->id,
            'model'         => 'User',
            'message'       =>  'An Employee <a href='.route("admin.employees.show", $employee->id) .'>'.$employee->firstname.' '.$employee->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        return redirect()->route('admin.employees.index', ['status' => true])->with('success', 'Employee Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Employee::find($id)->delete();
        return redirect()->back()->with('success', 'Employee deleted successfully!');
    }

    public function changeStatus($id)
    {
        $employee = Employee::find($id);
        if ($employee->status == true) {
            Employee::find($id)->update(['status' => false]);
            return redirect()->route('admin.employees.index')->with('warning', 'Employee has been disabled successfully!');
        } else {
            Employee::find($id)->update(['status' => true]);
            return redirect()->route('admin.employees.index')->with('success', 'Employee has been enabled successfully!');
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        Employee::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'Employee password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Employee::whereIn('id', $request->employees)->delete();
        return response()->json(['success' => 'Employees deleted successfully!'], 200);
    }

    public function approvalForm($id)
    {
        $employee          = Employee::find($id);
        $employee->avatar  = isset($employee->avatar) ? asset('storage/uploads/employee/' . $employee->avatar) : URL::to('assets/images/employees/avatar.png');
        $employee->country = Country::where('code', $employee->iso2)->first()->name;
        return view('admin.employees.approve', compact('employee'));
    }

    public function approve(Request $request, $id)
    {
        Employee::find($id)->update(['status' => true]);
        $user = Employee::find($id);

        switch (Auth::user()->role) {
            case 'Superadmin':
                $route = route('admin.superadmins.show', Auth::user()->id);
                break;
            case 'Admin':
                $route = route('admin.admins.show', Auth::user()->id);
                break;
            default:
                $route = route('admin.admins.show', Auth::user()->id);
                break;
        }

        Notification::create([
            'type'          => 'Employee approved',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $user->id,
            'model'         => 'User',
            'message'       => 'An employee <a href='.route("admin.employees.show", $user->id) .'>'.$user->firstname.' '.$user->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        Notification::create([
            'type'          => 'Employee approved',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Customer',
            'receiver_id'   => $user->id,
            'model_id'      => $user->id,
            'model'         => 'User',
            'message'       => 'Welcome to RSM! Your Employee account has been approved now by the administrator!',
        ]);

        $user->notify(new ApprovalNotification());
        return redirect()->route('admin.employees.index', ['status' => true])->with('success', 'Employee approved successfully!');
    }
    public function documentDelete(Request $request){
        EmployeeDocument::find($request->document_id)->delete();

        return response()->json(['success'=>'Document delete successfully.']);
    }
}
