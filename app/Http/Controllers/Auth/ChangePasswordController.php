<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePasswordForm()
    {
        $id         = Auth::user()->id;
        $tutor      = User::find($id);
        return view('employer.change-password', compact('tutor'));
    }

    public function changePassword(Request $request)
    {
        $id         =  Auth::user()->id;

        $this->validate($request, [
            'current_password'      => 'required',
            'new_password'          => 'required|min:8|confirmed',

        ]);

        $tutor                       = User::find($id);

        if (Hash::check($request->get('current_password'), $tutor->password)) {

            $tutor->password = Hash::make($request->new_password);
            $tutor->save();

            return redirect()->route('password.form')->with('success', 'Password changed successfully!');

        } else {

            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        return redirect()->route('password.form')->with('success', 'Password changed successfully');
    }

}
