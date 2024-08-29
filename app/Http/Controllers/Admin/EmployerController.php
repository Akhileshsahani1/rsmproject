<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Employer\ApprovalNotification;

class EmployerController extends Controller
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

        $employers              = User::query();
        $employers              = isset($filter['name']) ? $employers->where('company_name', 'LIKE', '%' . $filter['name'] . '%') : $employers;
        $employers              = isset($filter['email']) ? $employers->where('email', 'LIKE', '%' . $filter['email'] . '%') : $employers;
        $employers              = isset($filter['phone']) ? $employers->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $employers;
        $employers              = isset($filter['status']) ? $employers->where('status', $filter['status']) : $employers;

        $employers              = $employers->orderBy('id', 'desc')->paginate(20);

        return view('admin.employers.list', compact('employers', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'owner_name'        => ['required', 'string', 'max:255'],
            'company_name'      => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'             => ['required', 'min:8', 'unique:users'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'address'           => ['required']
        ]);

        $employer                       = new User();
        $employer->company_name         = $request->company_name;
        $employer->owner_name           = $request->owner_name;
        $employer->email                = $request->email;
        $employer->email_additional     = $request->email_additional;
        $employer->password             = Hash::make($request->password);
        $employer->dialcode             = $request->dialcode;
        $employer->phone                = $request->phone;
        $employer->address              = $request->address;
        $employer->city                 = $request->city;
        $employer->state                = $request->state;
        $employer->zipcode              = $request->zipcode;
        $employer->iso2                 = $request->iso2;
        $employer->website              = $request->website;
        $employer->description          = $request->description;
        $employer->status               = true;
        $employer->email_verified_at    = now();

        $employer->save();

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/employers/'.$employer->slug.'/'.'avatar', $name, 'public');

            User::find($employer->id)->update(['avatar' => $name]);
        }


        switch (Auth::user()->role) {
            case 'Superadmin':
                $route = route('admin.superadmins.show', Auth::user()->id);
                break;
            case 'Admin':
                $route = route('admin.admins.show', Auth::user()->id);
                break;
            case 'Account User':
                $route = route('admin.account-users.show', Auth::user()->id);
                break;
            default:
                $route = route('admin.admins.show', Auth::user()->id);
                break;
        }

        Notification::create([
            'type'          => 'Employer added',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $employer->id,
            'model'         => 'User',
            'message'       =>  'An Employer <a href='.route("admin.employers.show", $employer->id) .'>'.$employer->company_name.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);


        return redirect()->route('admin.employers.index', ['status' => true])->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employer          = User::find($id);
        $employer->avatar  = isset($employer->avatar) ? asset('storage/uploads/employers/' . $employer->slug.'/avatar'.'/'.$employer->avatar) : URL::to('assets/images/users/avatar.png');
        $employer->country = Country::where('code', $employer->iso2)->first()->name;
        return view('admin.employers.show', compact('employer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employer          = User::find($id);
        $employer->avatar  = isset($employer->avatar) ? asset('storage/uploads/employers/' . $employer->slug.'/avatar'.'/'.$employer->avatar) : URL::to('assets/images/users/avatar.png');
        $employer->thumbnail  = isset($employer->thumbnail) ? asset('storage/uploads/employer/' . $employer->thumbnail) : 'https://via.placeholder.com/100x100.png';
        return view('admin.employers.edit', compact('employer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'owner_name'        => ['required', 'string', 'max:255'],
            'company_name'      => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone'             => ['required', 'min:8', 'unique:users,phone,' . $id],
            'address'           => ['required']
        ]);

        $employer                       = User::find($id);
        $employer->company_name         = $request->company_name;
        $employer->owner_name            = $request->owner_name;
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


        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            

            if (isset($employer->avatar)) {

                $path   = 'uploads/employers/'.$employer->slug.'/'.'avatar' . $employer->avatar;

                Storage::delete($path);
            }

            $image->storeAs('uploads/employers/'.$employer->slug.'/'.'avatar', $name, 'public');

            $employer->avatar = $name;
        }

        $employer->save();


       

        switch (Auth::user()->role) {
            case 'Superadmin':
                $route = route('admin.superadmins.show', Auth::user()->id);
                break;
            case 'Admin':
                $route = route('admin.admins.show', Auth::user()->id);
                break;
            case 'Account User':
                $route = route('admin.account-users.show', Auth::user()->id);
                break;
            default:
                $route = route('admin.admins.show', Auth::user()->id);
                break;
        }

        Notification::create([
            'type'          => 'Employer updated',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $employer->id,
            'model'         => 'User',
            'message'       =>  'An Employer <a href='.route("admin.employers.show", $employer->id) .'>'.$employer->company_name.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        return redirect()->route('admin.employers.index', ['status' => true])->with('success', 'Employee Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Employer deleted successfully!');
    }

    public function changeStatus($id)
    {
        $employer = User::find($id);
        if ($employer->status == true) {
            User::find($id)->update(['status' => false]);
            return redirect()->route('admin.employers.index')->with('warning', 'Employer has been disabled successfully!');
        } else {
            User::find($id)->update(['status' => true]);
            return redirect()->route('admin.employers.index')->with('success', 'Employer has been enabled successfully!');
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'Employer password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        User::whereIn('id', $request->employers)->delete();
        return response()->json(['success' => 'Employers deleted successfully!'], 200);
    }

    public function approvalForm($id)
    {
        $employer          = User::find($id);
        $employer->avatar  = isset($employer->avatar) ? asset('storage/uploads/admin/' . $employer->avatar) : URL::to('assets/images/users/avatar.png');
        $employer->country = Country::where('code', $employer->iso2)->first()->name;


        return view('admin.employers.approve', compact('employer'));
    }

    public function approve(Request $request, $id)
    {
        User::find($id)->update(['status' => true]);
        $user = User::find($id);

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
            'type'          => 'Employer approved',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $user->id,
            'model'         => 'User',
            'message'       => 'An Employer <a href='.route("admin.employers.show", $user->id) .'>'.$user->company_name.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        Notification::create([
            'type'          => 'Employer approved',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Customer',
            'receiver_id'   => $user->id,
            'model_id'      => $user->id,
            'model'         => 'User',
            'message'       => 'Welcome to RSM! Your employer account has been approved now by the administrator!',
        ]);

        $user->notify(new ApprovalNotification());
        return redirect()->route('admin.employers.index', ['status' => true])->with('success', 'Employer approved successfully!');
    }
}
