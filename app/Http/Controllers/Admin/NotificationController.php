<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
        switch (Auth::user()->role) {

            case 'Superadmin':
                $notifications = Notification::whereIn('receiver', ['Admin', 'Superadmin','Account']);
                break;
            case 'Admin':
                $notifications = Notification::where('receiver', 'Admin');
                break;
           
            default:
                $notifications = Notification::where('receiver', 'Account');
                break;
        }

        $filter                 = [];
        $filter['action_by']    = $request->action_by;
        $filter['action_date']  = $request->action_date;
        $filter['search']       = $request->search;

        $notifications = ($filter['action_by']) ? $notifications->where('receiver',$filter['action_by']):$notifications;
        $notifications = ($filter['action_date']) ? $notifications->whereDate('created_at',$filter['action_date']):$notifications;
        $notifications = ($filter['search']) ? $notifications->where('message', 'LIKE', '%' . $filter['search'] . '%'):$notifications;

        $notifications = $notifications->orderBy('id', 'desc')->paginate(30);
       
        return view('admin.notifications.list', compact('notifications','filter'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
