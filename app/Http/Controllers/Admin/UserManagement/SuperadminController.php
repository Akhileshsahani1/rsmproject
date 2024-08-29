<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Models\Notification;
use Auth;

class SuperadminController extends Controller
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
        $filter['status']       = $request->status;

        $superadmins            = Administrator::where('role', 'Superadmin');
        $superadmins            = isset($filter['name']) ? $superadmins->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $superadmins;
        $superadmins            = isset($filter['email']) ? $superadmins->where('email', 'LIKE', '%' . $filter['email'] . '%') : $superadmins;
        $superadmins            = isset($filter['phone']) ? $superadmins->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $superadmins;
        
        if(isset($filter['status'])){
            if($filter['status'] == 'Yes'){
                $superadmins      = $superadmins->where('status', true);
            }

            if($filter['status'] == 'No'){
                $superadmins      = $superadmins->where('status', false);
            }
        }
        
        $superadmins          = $superadmins->orderBy('id', 'desc')->paginate(20);

        return view('admin.user-management.superadmins.list', compact('superadmins', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user-management.superadmins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:administrators'],
            'phone'     => ['required', 'min:8', 'unique:administrators'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'status'    => ['required']
        ]);

        $superadmin                         = new Administrator();
        $superadmin->firstname              = $request->firstname;
        $superadmin->lastname               = $request->lastname;
        $superadmin->email                  = $request->email;
        $superadmin->password               = Hash::make($request->password);        
        $superadmin->dialcode               = $request->dialcode;
        $superadmin->role                   = 'Superadmin';
        $superadmin->phone                  = $request->phone;
        $superadmin->status                 = $request->status;
        $superadmin->gender                 = $request->gender;
        $superadmin->address                = $request->address;
        $superadmin->city                   = $request->city;
        $superadmin->state                  = $request->state;
        $superadmin->zipcode                = $request->zipcode;
        $superadmin->iso2                   = $request->iso2;
        $superadmin->email_verified_at      = now();

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/admin/', $name, 'public');            

            $superadmin->avatar = $name;
        }

        $superadmin->save();

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
            'type'          => 'SuperAdmin added',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $superadmin->id,
            'model'         => 'User',
            'message'       =>  'An SuperAdmin <a href='.route("admin.superadmins.show", $superadmin->id) .'>'.$superadmin->firstname.' '.$superadmin->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        return redirect()->route('admin.superadmins.index')->with('success', 'Admin created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $superadmin          = Administrator::find($id);
        $superadmin->avatar  = isset($superadmin->avatar) ? asset('storage/uploads/admin/'.$superadmin->avatar) : URL::to('assets/images/users/avatar.png') ;
        $superadmin->country = Country::where('code', $superadmin->iso2)->first()->name;
        return view('admin.user-management.superadmins.show', compact('superadmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $superadmin          = Administrator::find($id);
        $superadmin->avatar  = isset($superadmin->avatar) ? asset('storage/uploads/admin/'.$superadmin->avatar) : URL::to('assets/images/users/avatar.png') ;
        return view('admin.user-management.superadmins.edit', compact('superadmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:administrators,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:administrators,phone,' . $id],
            'status'    => ['required']
        ]);

        $superadmin                  = Administrator::find($id);
        $superadmin->firstname       = $request->firstname;
        $superadmin->lastname        = $request->lastname;
        $superadmin->email           = $request->email;
        $superadmin->dialcode        = $request->dialcode;
        $superadmin->phone           = $request->phone;
        $superadmin->status          = $request->status;
        $superadmin->gender          = $request->gender;
        $superadmin->address         = $request->address;
        $superadmin->city            = $request->city;
        $superadmin->state           = $request->state;
        $superadmin->zipcode         = $request->zipcode;
        $superadmin->iso2            = $request->iso2;

        if($request->hasfile('avatar')){

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/admin/', $name, 'public');

            if(isset($superadmin->avatar)){

                $path   = 'public/uploads/admin/'.$superadmin->avatar;

                Storage::delete($path);

            }

            $superadmin->avatar = $name;

        }

        $superadmin->save();

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
            'type'          => 'SuperAdmin updated',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $superadmin->id,
            'model'         => 'User',
            'message'       =>  'An SuperAdmin <a href='.route("admin.superadmins.show", $superadmin->id) .'>'.$superadmin->firstname.' '.$superadmin->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        return redirect()->route('admin.superadmins.index')->with('success', 'Superadmin updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Administrator::find($id)->delete();
        return redirect()->route('admin.superadmins.index')->with('success', 'Superadmin deleted successfully!');
    }

    public function changeStatus($id){
        $admin = Administrator::find($id);
        if($admin->status == true){
            Administrator::find($id)->update(['status' => false]);
            return redirect()->route('admin.superadmins.index')->with('warning', 'Superadmin has been disabled successfully!');
        }else{
            Administrator::find($id)->update(['status' => true]);
            return redirect()->route('admin.superadmins.index')->with('success', 'Superadmin has been enabled successfully!');
        }
    }    

    public function resetPassword(Request $request){
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        // Administrator::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
         
        $superadmin = Administrator::find($request->id);
        $superadmin->password = Hash::make($request->password);
        $superadmin->save();
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
            'type'          => 'SuperAdmin added',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $superadmin->id,
            'model'         => 'User',
            'message'       =>  'An SuperAdmin <a href='.route("admin.superadmins.show", $superadmin->id) .'>'.$superadmin->firstname.' '.$superadmin->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);
        return redirect()->route('admin.superadmins.index')->with('success', 'Superadmin password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Administrator::whereIn('id', $request->admins)->delete();
        return response()->json(['success' => 'Superadmins deleted successfully!'], 200);
    }
}
