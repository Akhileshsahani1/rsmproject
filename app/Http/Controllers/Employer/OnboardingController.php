<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function stepOne(){
        $id                 = Auth::user()->id;
        $employer           = User::find($id);      
        $countries          = Country::get(['code', 'name']);
        $employer->avatar   = isset($employer->avatar) ? asset('storage/uploads/employers/'.$employer->slug.'/avatar'.'/'.$employer->avatar) : URL::to('assets/images/users/employer-avatar.png') ;
        return view('employer.onboarding.step-1', compact('employer', 'countries'));
    }

    public function saveStepOne(Request $request){
        $id = Auth::user()->id;

        $this->validate($request, [  
            'owner_name'      => ['required'],  
            'website'           => ['required'],           
            'address'           => ['required'],
            'city'              => ['required'],
            'state'             => ['required'],
            'zipcode'           => ['required'],
        ]);

        $user                       = User::find($id);      
        $user->owner_name           = $request->owner_name;     
        $user->website              = $request->website;     
        $user->address              = $request->address;
        $user->city                 = $request->city;
        $user->state                = $request->state;
        $user->zipcode              = $request->zipcode;
        $user->iso2                 = $request->country;
        $user->save();
        
        return redirect()->route('home')->with('success', 'Onboarding Process completed successfully!');
    }   

    public function uploadAvatar(Request $request){
        $id                 = Auth::user()->id;
        $employer           = User::find($id);      
        
        Storage::deleteDirectory('public/uploads/employers/'.$employer->slug);

        $image_parts      = explode(";base64,", $request->image);
        $image_type_aux   = explode("image/", $image_parts[0]);
        $image_type       = $image_type_aux[1];
        $image_base64     = base64_decode($image_parts[1]);
        $image_name       = uniqid() . '.png';
        Storage::disk('public')->put('uploads/employers/'.$employer->slug.'/'.'avatar/'.$image_name, $image_base64);

        User::where('id', $id)->update(['avatar' => $image_name]);
        return response()->json(['success' => 'Image Uploaded Successfully']);
    }

    public function myProfile(){
        $id                 = Auth::user()->id;
        $employer           = User::find($id);      
        $countries          = Country::get(['code', 'name']);
        $employer->avatar   = isset($employer->avatar) ? asset('storage/uploads/employers/'.$employer->slug.'/avatar'.'/'.$employer->avatar) : URL::to('assets/images/users/employer-avatar.png') ;
        return view('employer.my-profile', compact('employer', 'countries'));
    }
    public function myEditProfile(){
        $id                 = Auth::user()->id;
        $employer           = User::find($id);      
        $countries          = Country::get(['code', 'name']);
        $employer->avatar   = isset($employer->avatar) ? asset('storage/uploads/employers/'.$employer->slug.'/avatar'.'/'.$employer->avatar) : URL::to('assets/images/users/employer-avatar.png') ;
        return view('employer.edit-profile', compact('employer', 'countries'));
    }

    public function saveProfile(Request $request){
        $id                 = Auth::user()->id;
        $this->validate($request, [
            'owner_name'        => ['required', 'string', 'max:255'],
            'company_name'      => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone'             => ['required', 'min:8', 'unique:users,phone,' . $id] ,  
            'description'       => ($request->description) ? ['min:100','max:300'] :''
        ]);

        $employer                       = User::find($id);
        $employer->company_name         = $request->company_name;
        $employer->owner_name           = $request->owner_name;     
        $employer->email                = $request->email;
        $employer->email_additional     = $request->email_additional;     
        $employer->dialcode             = $request->dialcode;
        $employer->phone                = $request->phone;       
        $employer->address              = $request->address;
        $employer->city                 = $request->city;
        $employer->state                = $request->state;
        $employer->zipcode              = $request->zipcode;
        $employer->iso2                 = $request->iso2;
        $employer->website              = $request->website;
        $employer->description          = $request->description;
        $employer->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
