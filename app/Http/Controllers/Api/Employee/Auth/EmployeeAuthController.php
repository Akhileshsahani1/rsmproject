<?php

namespace App\Http\Controllers\Api\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\Nationality;
use App\Models\PreferredClassification;
use App\Models\PreferredSubClassification;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EmployeeAuthController extends Controller
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'email'     => ['required', 'string', 'email', 'max:255'],
            'password'  => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        if (Auth::guard('employee')->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ])) {

            $user        = Employee::find(auth()->guard('employee')->user()->id);
            $user->avatar  = $user->avatar   = isset($user->avatar) ? asset('storage/uploads/employees/' . $user->id . '/avatar' . '/' . $user->avatar) : URL::to('assets/images/users/employee-avatar.png');
            $user->token = $user->createToken('Employee', ['employee'])->accessToken;

            return response()->json($user, 200);
        } else {
            return response()->json(['errors' => ['email' => 'These credentials do not match our records.']]);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'phone' => ['required', 'min:10', 'unique:employees'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $input                   = $request->all();
        $input['password']       = bcrypt($input['password']);
        $input['dialcode']       = isset($request->dialcode) ? $request->dialcode : '+65';
        $input['iso2']           = isset($request->iso2) ? $request->iso2 : 'sg';
        $input['remember_token'] = Str::random(64);
        $user                    = Employee::create($input);
        $user->token             = $user->createToken('Employee', ['employee'])->accessToken;

        return response()->json($user, 200);
    }

    public function onBoardingData(Request $request)
    {

        $id                 = Auth::user()->id;
        $employee           = Employee::find($id);
        $nationalities      = Nationality::get(['nationality']);
        $countries          = Country::get(['code', 'name']);
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/' . $employee->slug . '/avatar' . '/' . $employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
        $classifications    = PreferredClassification::get();
        $skills             = Skill::where('status', 1)->get();
        if (isset($employee->classification_id)) {
            $subclassifications = PreferredSubClassification::where('classification_id', $employee->classification_id)->get();
        } else {
            $subclassifications = [];
        }

        return response()->json([
            'message'            => 'success',
            'skills'             => $skills,
            'nationalities'      => $nationalities,
            'countries'          => $countries,
            'classifications'    => $classifications,
            'subclassifications' => $subclassifications
        ]);
    }

    public function registerOnboarding(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'preferred_classification'     => ['required'],
            'sub_classification'           => ['required'],
            'address'                      => ['required'],
            'city'                         => ['required'],
            'state'                        => ['required'],
            'zipcode'                      => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $employee                         = Employee::find($id);

        if ($request->hasfile('image')) {

            $image      = $request->file('image');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employees/' . $employee->slug . '/' . 'avatar', $name, 'public');


            if (isset($employee->avatar)) {

                $path   = 'public/uploads/employees/' . $employee->slug . '/' . 'avatar/' . $employee->avatar;

                Storage::delete($path);
            }

            Employee::where('id', $id)->update(['avatar' => $name]);
        }
        $employee->classification_id      = $request->preferred_classification;
        $employee->sub_classification_id  = $request->sub_classification;
        $employee->address                = $request->address;
        $employee->city                   = $request->city;
        $employee->state                  = $request->state;
        $employee->zipcode                = $request->zipcode;
        $employee->save();

        return response()->json([
            'status_code' => 200,
            'message'     => 'Register on boarding success',
            'employee'    => $employee
        ]);
    }
    /**
     * User Detail api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $employee           = Auth::user();
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/' . $employee->slug . '/avatar' . '/' . $employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
        return response()->json(['success' => $employee], 200);
    }

    public function employeeFullData()
    {

        $user = Auth::user();
        $employee = Employee::where('id', $user->id)->with('preferredclassification', 'preferredsubclassification')->first();
        $employee->avatar   = isset($employee->avatar) ? asset('storage/uploads/employees/' . $employee->slug . '/avatar' . '/' . $employee->avatar) : URL::to('assets/images/users/employee-avatar.png');
        return response()->json(['profile' => $employee], 200);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success' => 'Logged Out Successfully!'], 200);
    }

    public function employeeUpdateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'preferredclassification'      => ['required'],
            'preferredsubclassification'   => ['required'],
            'address'                      => ['required'],
            'city'                         => ['required'],
            'state'                        => ['required'],
            'zipcode'                      => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }


        $employee = Employee::find(Auth::user()->id);

        Employee::where('id', Auth::user()->id)->update([

            'address'                        => !is_null($request->address) ? $request->address : $employee->address,
            'city'                           => !is_null($request->city) ? $request->city : $employee->city,
            'description'                    => !is_null($request->description) ? $request->description : $employee->description,
            'email'                          => !is_null($request->email) ? $request->email : $employee->email,
            'external_link'                  => !is_null($request->external_link) ? $request->external_link : $employee->external_link,
            'highest_education'              => !is_null($request->highest_education) ? $request->highest_education : $employee->highest_education,
            'firstname'                      => !is_null($request->firstname) ? $request->firstname : $employee->firstname,
            'lastname'                       => !is_null($request->lastname) ? $request->lastname : $employee->lastname,
            'gender'                         => !is_null($request->gender) ? $request->gender : $employee->gender,
            'job_skill'                      => !is_null($request->job_skill) ? $request->job_skill : $employee->job_skill,
            'nationality'                    => !is_null($request->nationality) ? $request->nationality : $employee->nationality,
            'phone'                          => !is_null($request->phone) ? $request->phone : $employee->phone,
            'classification_id'              => !is_null($request->preferredclassification) ? $request->preferredclassification : $employee->classification_id,
            'sub_classification_id'          => !is_null($request->preferredsubclassification) ? $request->preferredsubclassification : $employee->sub_classification_id,
            'profile_visibility'             => !is_null($request->profile_visibility) ? $request->profile_visibility : $employee->profile_visibility,
            'state'                          => !is_null($request->state) ? $request->state : $employee->state,
            'zipcode'                        => !is_null($request->zipcode) ? $request->zipcode : $employee->zipcode

        ]);



        $user = Employee::find(Auth::user()->id);

        if ($request->hasfile('image')) {

            $image      = $request->file('image');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employees/' . $user->id . '/' . 'avatar', $name, 'public');


            if (isset($user->avatar)) {

                $path   = 'public/uploads/employees/' . $user->id . '/' . 'avatar/' . $user->avatar;

                Storage::delete($path);
            }

            Employee::where('id', $user->id)->update(['avatar' => $name]);
        }

        $user->avatar   = isset($user->avatar) ? asset('storage/uploads/employees/' . $user->id . '/avatar' . '/' . $user->avatar) : URL::to('assets/images/users/employee-avatar.png');

        return response()->json([
            'status_code' => 200,
            'user'        => $user,
            'message'     => 'Profile updated successfully'
        ]);
    }

    public function updatePicture(Request $request)
    {

        $employee = Employee::find(Auth::user()->id);

        if ($request->hasfile('image')) {

            $image      = $request->file('image');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employees/' . $employee->slug . '/' . 'avatar/', $name, 'public');

            if (isset($employee->avatar)) {

                $path   = 'public/uploads/employees/' . $employee->slug . '/' . 'avatar/' . $employee->avatar;

                Storage::delete($path);
            }

            Employee::where('id', Auth::user()->id)->update(['avatar' => $name]);

            return response()->json([
                'status_code' => 200
            ]);
        }
    }

    public function updateProfile($request)
    {

        $employee = Employee::find(Auth::user()->id);

        Employee::where('id', Auth::user()->id)->update([

            'address'                        => !is_null($request->address) ? $request->address : $employee->address,
            'city'                           => !is_null($request->city) ? $request->city : $employee->city,
            'description'                    => !is_null($request->description) ? $request->description : $employee->description,
            'email'                          => !is_null($request->email) ? $request->email : $employee->email,
            'external_link'                  => !is_null($request->external_link) ? $request->external_link : $employee->external_link,
            'highest_education'              => !is_null($request->highest_education) ? $request->highest_education : $employee->highest_education,
            'firstname'                      => !is_null($request->firstname) ? $request->firstname : $employee->firstname,
            'lastname'                       => !is_null($request->lastname) ? $request->lastname : $employee->lastname,
            'gender'                         => !is_null($request->gender) ? $request->gender : $employee->gender,
            'job_skill'                      => !is_null($request->job_skill) ? $request->job_skill : $employee->job_skill,
            'nationality'                    => !is_null($request->nationality) ? $request->nationality : $employee->nationality,
            'phone'                          => !is_null($request->phone) ? $request->phone : $employee->phone,
            'classification_id'              => !is_null($request->preferredclassification) ? $request->preferredclassification : $employee->classification_id,
            'sub_classification_id'          => !is_null($request->preferredsubclassification) ? $request->preferredsubclassification : $employee->sub_classification_id,
            'profile_visibility'             => !is_null($request->profile_visibility) ? $request->profile_visibility : $employee->profile_visibility,
            'state'                          => !is_null($request->state) ? $request->state : $employee->state,
            'zipcode'                        => !is_null($request->zipcode) ? $request->zipcode : $employee->zipcode

        ]);
    }

    public function stepOneUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'email'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $this->updateProfile($request);
        $employee = Employee::find(Auth::user()->id);
        return response()->json(['status_code' => 200,'employee'=>$employee]);
    }

    public function stepTwoUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'preferredclassification'      => ['required'],
            'preferredsubclassification'   => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $this->updateProfile($request);

        return response()->json(['status_code' => 200]);
    }

    public function stepThreeUpdate(Request $request)
    {
        $this->updateProfile($request);

        return response()->json(['status_code' => 200]);
    }

    public function uploadDocs(Request $request)
    {

        $employee = Employee::find(Auth::user()->id);

        if ($request->hasfile('documents')) {

            foreach ($request->file('documents') as $file) {
                $document_name =  $file->getClientOriginalName();
                $file->storeAs('uploads/employees/' . $employee->slug . '/' . 'documents/', $document_name, 'public');
                EmployeeDocument::create([
                    'employee_id' => $employee->id,
                    'name'     => $document_name
                ]);
            }

            return response()->json([
                'message' => 'Document(s) updated successfully.'
            ]);
        }
    }

    public function getDocs()
    {

        $docs = EmployeeDocument::where('employee_id', Auth::user()->id)->get();
        $docs = $docs->map(function($d){
            return [
                'doc' => asset('storage/uploads/employees/'.Auth::user()->slug.'/'.'documents').'/'.$d->name
            ];
        });
        return response()->json(['docs' => $docs]);
    }
}
