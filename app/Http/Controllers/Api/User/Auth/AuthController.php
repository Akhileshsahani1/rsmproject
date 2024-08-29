<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ApplyJob;
use App\Models\Country;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Responseuser
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

        if (Auth::attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ])) {

            $user        = User::find(auth()->user()->id);
            $user->token = $user->createToken('User', ['user'])->accessToken;

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
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'min:10', 'unique:users'],
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
        $input['status']         = 0;
        $user                    = User::create($input);
        $user->token             = $user->createToken('User', ['user'])->accessToken;

        return response()->json($user, 200);
    }
    /**
     * User Detail api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }

    public function onBoardData(Request $request)
    {

        $countries = Country::get();

        return response()->json([
            'countries' => $countries
        ]);
    }

    public function onBoardProcess(Request $request)
    {

        $id = Auth::user()->id;

        $validate = Validator::make($request->all(), [
            'owner_name'        => ['required'],
            // 'website'           => ['required'],
            'address'           => ['required'],
            'city'              => ['required'],
            // 'state'             => ['required'],
            // 'zipcode'           => ['required'],
            'country'           => ['required']
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->messages()]);
        }

        $user                       = User::find($id);
        $user->owner_name           = $request->owner_name;
        $user->website              = $request->website;
        $user->address              = $request->address;
        $user->city                 = $request->city;
        $user->state                = $request->state;
        $user->zipcode              = $request->zipcode;
        $user->iso2                 = $request->country;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.'
        ]);
    }


    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success' => 'Logged Out Successfully!'], 200);
    }

    public function viewProfile()
    {
        $id = Auth::user()->id;

        $user = User::where('id', $id)->with('jobs', 'openjobs', 'closejobs')->first();
        $user->avatar   = isset($user->avatar) ? asset('storage/uploads/employer/' . $user->id . '/avatar' . '/' . $user->avatar) : URL::to('assets/images/users/employer-avatar.png');
        return response()->json([
            'user' => $user
        ]);
    }

    public function editProfile(Request $request)
    {

        $id = Auth::user()->id;

        $user                       = User::find($id);
        $user->company_name         = $request->company_name;
        $user->description          = $request->description;
        $user->website              = $request->website;
        $user->address              = $request->address;
        $user->city                 = $request->city;
        $user->state                = $request->state;
        $user->zipcode              = $request->zipcode;
        //  $user->iso2                 = $request->country;
        $user->save();

        return response()->json([
            'status_code' => 200,
            'message' => 'Profile updated successfully.'
        ]);
    }

    public function editAvatar(Request $request){

        $id   = Auth::user()->id;
        $user = User::find($id);

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employer/' . $user->id . '/' . 'avatar', $name, 'public');

            if (isset($user->avatar)) {

                $path   = 'public/uploads/employer/' . $user->id . '/' . 'avatar'.'/'. $user->avatar;

                Storage::delete($path);
            }

            User::where('id', $id)->update(['avatar' => $name]);
        }
        return response()->json([
            'status_code' => 200,
            'message' => 'avatar updated successfully.'
        ]);

    }

    public function viewApplicant(Request $request)
    {

        $e = ApplyJob::find($request->applied_id);

        $e->employee->avatar   = isset($e->employee->avatar) ? asset('storage/uploads/employees/' . $e->employee->slug . '/avatar' . '/' . $e->employee->avatar) : URL::to('assets/images/users/employee-avatar.png');

        $applicant = [

            'applied_id'          => $e->id,
            'employee_id'         => $e->employee->id,
            'job_id'              => $e->job_id,
            'firstname'           => $e->employee->firstname,
            'lastname'            => $e->employee->lastname,
            'avatar'              => $e->employee->avatar,
            'classification'      => $e->employee->preferredclassification->classification,
            'sub_classification'  => $e->employee->preferredsubclassification->sub_classification,
            'education'           => $e->employee->highest_education,
            'address'             => $e->employee->address,
            'city'                => $e->employee->city,
            'state'               => $e->employee->state,
            'zipcode'             => $e->employee->zipcode,
            'skills'              => $e->employee->job_skill,
            'phone'               => $e->employee->phone,
            'document'            => Helper::documentRequestExist($e->job_id, $e->employee->id),
            'bookmark_exist'      => Helper::employeeBookmarkExist($e->employee->id, Auth::user()->id),
            'applied_on'          => Carbon::parse($e->created_at)->format('M d,Y'),
            'description'         => $e->employee->description,
            'email'               => $e->employee->email,
            'whitelist'           => in_array($e->status,['rejected','white-list']) ? true : false,
            'rejected'            => ($e->status == 'rejected') ? true : false

        ];

        return response()->json([
            'applicant' => $applicant
        ]);
    }
}
