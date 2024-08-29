<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
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


        $pages                   = Page::get();               

        return view('admin.pages.list', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['required'],           
            'meta_title'        => ['required', 'string', 'max:255'],
            'meta_description'  => ['required'],
            'meta_keywords'     => ['required'],
        ]);

        $page                    = new Page;
        $page->name              = $request->name; 
        $page->description       = $request->description;     
        $page->meta_title        = $request->meta_title; 
        $page->meta_description  = $request->meta_description; 
        $page->meta_keywords     = $request->meta_keywords;                        
        $page->save();

        if ($request->hasfile('banner')) {

            $banner_image      = $request->file('banner');

            $banner_name       = $banner_image->getClientOriginalName();

            $banner_image->storeAs('uploads/pages/'.$page->slug.'/'.'banner', $banner_name, 'public');

            Page::find($page->id)->update(['banner' => $banner_name]);
        }        

        return redirect()->route('admin.pages.index')->with('success', 'Page '.$request->name.' added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {        
        $page               = Page::findBySlug($id);
        $page->banner       = isset($page->banner) ? asset('storage/uploads/pages/'.$page->slug.'/banner'.'/'.$page->banner) : 'https://via.placeholder.com/1920x400.png?text=Banner+Size+:+1920+x+400+px';        
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page               = Page::findBySlug($id);
        $page->banner       = isset($page->banner) ? asset('storage/uploads/pages/'.$page->slug.'/banner'.'/'.$page->banner) : 'https://via.placeholder.com/1920x400.png?text=Banner+Size+:+1920+x+400+px';        
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {       
        $this->validate($request, [
            'name'                   => ['required', 'string', 'max:255'],
            'description'            => ['required'],           
            'meta_title'             => ['required', 'string', 'max:255'],
            'meta_description'       => ['required'],
            'meta_keywords'          => ['required'],
        ]);

        $page                    = Page::find($id);
        $page->name              = $request->name; 
        $page->description       = $request->description;     
        $page->meta_title        = $request->meta_title; 
        $page->meta_description  = $request->meta_description; 
        $page->meta_keywords     = $request->meta_keywords;                        
        $page->save();

        if ($request->hasfile('banner')) {

            $banner_image      = $request->file('banner');

            $banner_name       = $banner_image->getClientOriginalName();

            $banner_image->storeAs('uploads/categories/'.$page->slug.'/'.'banner', $banner_name, 'public');

            if(isset($page->banner)){

                $old_banner_path   = 'public/uploads/pages/'.$page->slug.'/'.'banner/'.$page->banner;

                Storage::delete($old_banner_path);

            }

            Page::find($page->id)->update(['banner' => $banner_name]);
        }       

        return redirect()->route('admin.pages.index')->with('success', 'Page '.$request->name.' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findBySlug($id);        
        Storage::deleteDirectory('public/uploads/pages/'.$page->slug);
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
    }
}
