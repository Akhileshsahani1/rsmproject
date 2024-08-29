<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Administrator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
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
    public function show(Administrator $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $admin)
    {
        $id             = Auth::guard('administrator')->id();
        $admin          = Administrator::find($id);
        $admin->avatar  = isset($admin->avatar) ? asset('storage/uploads/admin/'.$admin->avatar) : URL::to('assets/images/users/avatar.png') ;
        return view('admin.settings.my-account', compact('admin'));
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
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:administrators,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:administrators,phone,' . $id],
        ]);

        $admin                  = Administrator::find($id);
        $admin->firstname       = $request->firstname;
        $admin->lastname        = $request->lastname;
        $admin->email           = $request->email;
        $admin->iso2            = $request->iso2;
        $admin->dialcode        = $request->dialcode;
        $admin->phone           = $request->phone;

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

        return redirect()->route('admin.my-account.edit', $admin->id)->with('success', 'Account updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $admin)
    {
        //
    }
}
