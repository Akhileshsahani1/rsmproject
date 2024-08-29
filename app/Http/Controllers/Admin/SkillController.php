<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::get();

        return view('admin.skills.list', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'skill'        => ['required', 'string', 'max:255'],
        ]);

        $exists = Skill::where('name',$request->skill)->exists();
        if($exists){
            return redirect()->route('admin.skills.index')->with('warning', 'Skill already exists!');
        }
        if($request->skill_id > 0 ){
          $skill = Skill::find($request->skill_id)->update(['name'=>$request->skill]);
          return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully!');
        }else{
            $skill = Skill::create(['name'=>$request->skill]);
            return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully!');
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $search)
    {
         $skills = Skill::where('status',true)->get(['name'])->toArray();

          return response()->json($skills);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $skill = Skill::find($id);
        if($skill->status){
           $skill->update(['status'=>false]);
        }else{
            $skill->update(['status'=>true]);
        }
        return response()->json(
         [
            'success' => 'Status Updated Successfully.'
         ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Skill::find($id)->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully!');
    }
}
