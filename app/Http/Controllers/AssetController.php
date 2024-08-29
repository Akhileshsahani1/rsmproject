<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Area;
use App\Models\CompanySetting;
use App\Models\Employee;
use App\Models\Administrator;
use App\Models\Page;
use App\Models\PreferredSubClassification;
use App\Models\SubZone;
use App\Notifications\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function getSubClassification(Request $request){
        $subclassifications = PreferredSubClassification::where('classification_id', $request->classification_id)->get();

        $output = '';
        $output .= '<option value="">Select Sub-classification</option>';
        foreach ($subclassifications as $subclassification) {
            $output .= '<option value="' . $subclassification->id . '">' . $subclassification->sub_classification . '</option>';
        }
        return response()->json($output);
    }

    public function getAreas(Request $request){
        $areas = Area::where('region_id', $request->region_id)->get();

        $output = '';
        $output .= '<option value="">Select Area</option>';
        foreach ($areas as $area) {
            $output .= '<option value="' . $area->id . '">' . $area->name . '</option>';
        }
        return response()->json($output);
    }

    public function getSubZones(Request $request){
        $subzones = SubZone::where('area_id', $request->area_id)->get();

        $output = '';
        $output .= '<option value="">Select Subzone</option>';
        foreach ($subzones as $subzone) {
            $output .= '<option value="' . $subzone->id . '">' . $subzone->name . '</option>';
        }
        return response()->json($output);
    }

    public function page($id){
        $page               = Page::findBySlug($id);
        $page->banner       = isset($page->banner) ? asset('storage/uploads/pages/'.$page->slug.'/banner'.'/'.$page->banner) : 'https://via.placeholder.com/1920x400.png?text=Banner+Size+:+1920+x+400+px';        
        return view('frontend.page.page', compact('page'));
    }

   

    public function employerApproval(){
        Auth::logout();
        return view('employer.approval-pending');
    }

    public function employeeApproval(){
        Auth::guard('employee')->logout();
        return view('employee.approval-pending');        
    }

    public function contactUs(){
        $company        = CompanySetting::find(1);
        $company->logo  = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo) : Helper::getlogo();
        return view('frontend.contact-us', compact('company'));
    }

    public function sendMessage(Request $request){

        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required',
            'phone_number'  => 'required',
            'message'       => 'required'
        ]);
        $admin = Administrator::find(1);
        Notification::route('mail', $admin->email )->notify(new ContactUs( $request->message, $request->email , $request->name , $request->phone_number  ));

        return redirect()->back()->with('success', 'Thank you for contacting us. We will reach you shortly.');
    }
}
