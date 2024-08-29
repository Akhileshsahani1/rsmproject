<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\Nationality;
use App\Models\PreferredClassification;
use App\Models\PreferredSubClassification;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class OnboardingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function process(){
        $id                 = Auth::user()->id;
        $employee           = Employee::find($id);
        $nationalities      = Nationality::get(['nationality']);
        $countries          = Country::get(['code', 'name']);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/employee-avatar.png') ;
        $classifications    = PreferredClassification::get();
        if(isset($employee->classification_id)){
            $subclassifications = PreferredSubClassification::where('classification_id', $employee->classification_id)->get();
        }else{
            $subclassifications = [];
        }
        return view('employee.onboarding.step-1', compact('employee', 'nationalities', 'countries', 'classifications', 'subclassifications'));
    }

    public function saveProcess(Request $request){
        $id = Auth::user()->id;

        $this->validate($request, [
            'preferred_classification'     => ['required'],
            'sub_classification'           => ['required'],
            'address'                      => ['required'],
            'city'                         => ['required'],
            'state'                        => ['required'],
            'zipcode'                      => ['required'],
        ]);

        $employee                         = Employee::find($id);
        $employee->classification_id      = $request->preferred_classification;
        $employee->sub_classification_id  = $request->sub_classification;
        $employee->address                = $request->address;
        $employee->city                   = $request->city;
        $employee->state                  = $request->state;
        $employee->zipcode                = $request->zipcode;
        $employee->save();

        return redirect()->route('employee.dashboard')->with('success', 'Onboarding process completed successfully!');
    }

    public function uploadAvatar(Request $request){
        $id                 = Auth::user()->id;
        $employee           = Employee::find($id);

        Storage::deleteDirectory('public/uploads/employees/'.$employee->slug);

        $image_parts      = explode(";base64,", $request->image);
        $image_type_aux   = explode("image/", $image_parts[0]);
        $image_type       = $image_type_aux[1];
        $image_base64     = base64_decode($image_parts[1]);
        $image_name       = uniqid() . '.png';
        Storage::disk('public')->put('uploads/employees/'.$employee->slug.'/'.'avatar/'.$image_name, $image_base64);

        Employee::where('id', $id)->update(['avatar' => $image_name]);
        return response()->json(['success' => 'Image Uploaded Successfully']);
    }

    public function myProfile(){
        $id                 = Auth::user()->id;
        $employee           = Employee::find($id);
        $nationalities      = Nationality::get(['nationality']);
        $classifications    = PreferredClassification::get();
        if(isset($employee->classification_id)){
            $subclassifications = PreferredSubClassification::where('classification_id', $employee->classification_id)->get();
        }else{
            $subclassifications = [];
        }
        $countries          = Country::get(['code', 'name']);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/employee-avatar.png') ;
        return view('employee.my-profile', compact('employee', 'nationalities', 'countries', 'classifications', 'subclassifications'));
    }
    public function editProfile(){
        $id                 = Auth::user()->id;
        $employee           = Employee::find($id);
        $nationalities      = Nationality::get(['nationality']);
        $classifications    = PreferredClassification::get();
        if(isset($employee->classification_id)){
            $subclassifications = PreferredSubClassification::where('classification_id', $employee->classification_id)->get();
        }else{
            $subclassifications = [];
        }
        $skills = Skill::where('status',true)->pluck('name')->toArray();
        $countries          = Country::get(['code', 'name']);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/'.$employee->slug.'/avatar'.'/'.$employee->avatar) : URL::to('assets/images/users/employee-avatar.png') ;
        return view('employee.edit-profile', compact('employee', 'skills','nationalities', 'countries', 'classifications', 'subclassifications'));
    }

    public function saveProfile(Request $request){
        $id                 = Auth::user()->id;
        $this->validate($request, [
            'firstname'                     => ['required', 'string', 'max:255'],
            'email'                         => ['required', 'string', 'email', 'max:255', 'unique:employees,email,' . $id],
            'phone'                         => ['required', 'min:8', 'unique:employees,phone,' . $id],
            'preferred_classification'      => ['required'],
            'sub_classification'            => ['required'],
            'nationality'                   => ['required'],
            'highest_education'             => ['required'],
            'job_skill'                    => ['required'],
            'profile_visibility'            => ['required'],
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
        $employee->job_skill            = $request->job_skill;
        $employee->description          = $request->description;
        $employee->profile_visibility   = $request->profile_visibility;
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
        foreach($request->job_skill as $new_skill){
            $exists = Skill::where('name',$new_skill)->exists();
            if(!$exists){
                Skill::create([
                 'name' => $new_skill,
                 'status' => false
                ]);
            }
         }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
