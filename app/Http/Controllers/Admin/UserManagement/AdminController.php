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

class AdminController extends Controller
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

        $admins                 = Administrator::where('role', 'Admin');
        $admins                 = isset($filter['name']) ? $admins->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $admins;
        $admins                 = isset($filter['email']) ? $admins->where('email', 'LIKE', '%' . $filter['email'] . '%') : $admins;
        $admins                 = isset($filter['phone']) ? $admins->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $admins;

        if(isset($filter['status'])){
            if($filter['status'] == 'Yes'){
                $admins          = $admins->where('status', true);
            }

            if($filter['status'] == 'No'){
                $admins          = $admins->where('status', false);
            }
        }

        $admins                 = $admins->orderBy('id', 'desc')->paginate(10);

        return view('admin.user-management.admins.list', compact('admins', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user-management.admins.create');
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

        $admin                      = new Administrator();
        $admin->firstname           = $request->firstname;
        $admin->lastname            = $request->lastname;
        $admin->email               = $request->email;
        $admin->password            = Hash::make($request->password);
        $admin->dialcode            = $request->dialcode;
        $admin->role                = 'Admin';
        $admin->phone               = $request->phone;
        $admin->gender              = $request->gender;
        $admin->address             = $request->address;
        $admin->city                = $request->city;
        $admin->state               = $request->state;
        $admin->zipcode             = $request->zipcode;
        $admin->iso2                = $request->iso2;
        $admin->email_verified_at   = now();

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/admin/', $name, 'public');            

            $admin->avatar = $name;
        }

        $admin->save();

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
            'type'          => 'Admin added',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $admin->id,
            'model'         => 'User',
            'message'       =>  'An Admin <a href='.route("admin.admins.show", $admin->id) .'>'.$admin->firstname.' '.$admin->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin          = Administrator::find($id);
        $admin->avatar  = isset($admin->avatar) ? asset('storage/uploads/admin/'.$admin->avatar) : URL::to('assets/images/users/avatar.png') ;
        $admin->country = Country::where('code', $admin->iso2)->first()->name;
        return view('admin.user-management.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin          = Administrator::find($id);
        $admin->avatar  = isset($admin->avatar) ? asset('storage/uploads/admin/'.$admin->avatar) : URL::to('assets/images/users/avatar.png') ;
        return view('admin.user-management.admins.edit', compact('admin'));
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

        $admin                  = Administrator::find($id);
        $admin->firstname       = $request->firstname;
        $admin->lastname        = $request->lastname;
        $admin->email           = $request->email;
        $admin->dialcode        = $request->dialcode;
        $admin->phone           = $request->phone;
        $admin->gender          = $request->gender;
        $admin->address         = $request->address;
        $admin->city            = $request->city;
        $admin->state           = $request->state;
        $admin->zipcode         = $request->zipcode;
        $admin->iso2            = $request->iso2;
        $admin->status          = $request->status;

        if($request->hasfile('avatar')){

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/admin/', $name, 'public');

            if(isset($admin->avatar)){

                $path   = 'public/uploads/admin/'.$admin->avatar;

                Storage::delete($path);

            }

            $admin->avatar = $name;

        }

        $admin->save();

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
            'type'          => 'Admin updated',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $admin->id,
            'model'         => 'User',
            'message'       =>  'An Admin <a href='.route("admin.admins.show", $admin->id) .'>'.$admin->firstname.' '.$admin->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Administrator::find($id)->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully!');
    }

    public function changeStatus($id){
        $admin = Administrator::find($id);
        if($admin->status == true){
            Administrator::find($id)->update(['status' => false]);
            return redirect()->route('admin.admins.index')->with('warning', 'Admin has been disabled successfully!');
        }else{
            Administrator::find($id)->update(['status' => true]);
            return redirect()->route('admin.admins.index')->with('success', 'Admin has been enabled successfully!');
        }
    }    

    public function resetPassword(Request $request){
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        
        $admin = Administrator::find($request->id);
        $admin->password = Hash::make($request->password);
        $admin->save();
    //    $admin =  Administrator::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
     
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
            'type'          => 'Admin password reset',
            'sender'        => 'Admin',
            'sender_id'     =>  Auth::user()->id,
            'receiver'      => 'Superadmin',
            'receiver_id'   => 1,
            'model_id'      => $admin->id,
            'model'         => 'User',
            'message'       =>  'An Admin <a href='.route("admin.admins.show", $admin->id) .'>'.$admin->firstname.' '.$admin->lastname.'</a> has been approved by '.Auth::user()->role.' <a href='.$route.'>'.Auth::user()->firstname.' '.Auth::user()->lastname.'</a>!',
        ]);
        return redirect()->route('admin.admins.index')->with('success', 'Admin password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Administrator::whereIn('id', $request->admins)->delete();
        return response()->json(['success' => 'Admins deleted successfully!'], 200);
    }
}
