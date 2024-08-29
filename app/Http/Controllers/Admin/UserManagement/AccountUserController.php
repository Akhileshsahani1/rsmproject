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

class AccountUserController extends Controller
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

        $account_users          = Administrator::where('role', 'Account User');
        $account_users          = isset($filter['name']) ? $account_users->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $account_users;
        $account_users          = isset($filter['email']) ? $account_users->where('email', 'LIKE', '%' . $filter['email'] . '%') : $account_users;
        $account_users          = isset($filter['phone']) ? $account_users->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $account_users;

        if(isset($filter['status'])){
            if($filter['status'] == 'Yes'){
                $account_users    = $account_users->where('status', true);
            }

            if($filter['status'] == 'No'){
                $account_users    = $account_users->where('status', false);
            }
        }

        $account_users          = $account_users->orderBy('id', 'desc')->paginate(20);

        return view('admin.user-management.account-users.list', compact('account_users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user-management.account-users.create');
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

        $account_user                       = new Administrator();
        $account_user->firstname            = $request->firstname;
        $account_user->lastname             = $request->lastname;
        $account_user->email                = $request->email;
        $account_user->password             = Hash::make($request->password);
        $account_user->dialcode             = $request->dialcode;
        $account_user->role                 = 'Account User';
        $account_user->phone                = $request->phone;
        $account_user->gender               = $request->gender;
        $account_user->address              = $request->address;
        $account_user->city                 = $request->city;
        $account_user->state                = $request->state;
        $account_user->zipcode              = $request->zipcode;
        $account_user->iso2                 = $request->iso2;
        $account_user->status               = $request->status;
        $account_user->email_verified_at    = now();

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/admin/', $name, 'public');            

            $account_user->avatar = $name;
        }

        $account_user->save();

        return redirect()->route('admin.account-users.index')->with('success', 'Account User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account_user          = Administrator::find($id);
        $account_user->avatar  = isset($account_user->avatar) ? asset('storage/uploads/admin/'.$account_user->avatar) : URL::to('assets/images/users/avatar.png') ;
        $account_user->country = Country::where('code', $account_user->iso2)->first()->name;
        return view('admin.user-management.account-users.show', compact('account_user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $account_user          = Administrator::find($id);
        $account_user->avatar  = isset($account_user->avatar) ? asset('storage/uploads/admin/'.$account_user->avatar) : URL::to('assets/images/users/avatar.png') ;
        return view('admin.user-management.account-users.edit', compact('account_user'));
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

        $account_user                  = Administrator::find($id);
        $account_user->firstname       = $request->firstname;
        $account_user->lastname        = $request->lastname;
        $account_user->email           = $request->email;       
        $account_user->dialcode        = $request->dialcode;
        $account_user->phone           = $request->phone;
        $account_user->status          = $request->status;
        $account_user->gender          = $request->gender;
        $account_user->address         = $request->address;
        $account_user->city            = $request->city;
        $account_user->state           = $request->state;
        $account_user->zipcode         = $request->zipcode;
        $account_user->iso2            = $request->iso2;

        if($request->hasfile('avatar')){

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/admin/', $name, 'public');

            if(isset($account_user->avatar)){

                $path   = 'public/uploads/admin/'.$account_user->avatar;

                Storage::delete($path);

            }

            $account_user->avatar = $name;

        }

        $account_user->save();

        return redirect()->route('admin.account-users.index')->with('success', 'Account User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Administrator::find($id)->delete();
        return redirect()->route('admin.account-users.index')->with('success', 'Account User deleted successfully!');
    }

    public function changeStatus($id){
        $admin = Administrator::find($id);
        if($admin->status == true){
            Administrator::find($id)->update(['status' => false]);
            return redirect()->route('admin.account-users.index')->with('warning', 'Account User has been disabled successfully!');
        }else{
            Administrator::find($id)->update(['status' => true]);
            return redirect()->route('admin.account-users.index')->with('success', 'Account User has been enabled successfully!');
        }
    }    

    public function resetPassword(Request $request){
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        Administrator::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('admin.account-users.index')->with('success', 'Account User password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Administrator::whereIn('id', $request->admins)->delete();
        return response()->json(['success' => 'Account Users deleted successfully!'], 200);
    }
}
