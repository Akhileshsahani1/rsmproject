<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrator;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function companyDetailsForm()
    {        
        $company        = CompanySetting::find(1);
        $company->logo  = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo) : Helper::getlogo();
        return view('admin.settings.company-details', compact('company'));
    }

    public function companyDetails(Request $request)
    {        

        $this->validate($request, [
            'company'           => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'address_line_1'    => 'required',
            'city'              => 'required',
            'zipcode'           => 'required',
            'state'             => 'required',
            'country'           => 'required',
            'website'           => 'required',
        ]);       

        CompanySetting::find(1)->update([
            'company'          => $request->company,
            'email'            => $request->email,
            'dialcode'         => $request->dialcode,
            'phone'            => $request->phone,
            'address_line_1'   => $request->address_line_1,
            'address_line_2'   => $request->address_line_2,
            'city'             => $request->city,
            'zipcode'          => $request->zipcode,
            'state'            => $request->state,
            'iso2'             => $request->country,
            'website'          => $request->website,
            'facebook_link'     => $request->facebook_link,
            'instagram_link'    => $request->instagram_link,
            'twitter_link'      => $request->twitter_link,
            'linkedin_link'     => $request->linkedin_link, 
            'google_play_link'  => $request->google_play_link,
            'apple_store_link'    => $request->apple_store_link,
            'description'       => $request->description        
        ]);

        if($request->hasfile('logo')){

            $image      = $request->file('logo');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/company/', $name, 'public');

            if(isset(CompanySetting::find(1)->logo)){

                $path   = 'public/uploads/company/'.CompanySetting::find(1)->logo;

                Storage::delete($path);

            }

            CompanySetting::find(1)->update(['logo' => $name]);

        }


        return redirect()->route('admin.company-details.form')->with('success', 'Company details updated successfully');
    }

}
