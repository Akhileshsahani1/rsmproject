<?php

namespace App\Http\Controllers\Employee;

use App\Models\Chat;
use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:employee']);
    }

    public function initiate(Request $request)
    {
        $job = Job::find($request->job_id);
        Chat::updateOrCreate([
            'job_id'        => $request->job_id,
            'employee_id'   => Auth::user()->id,
            'user_id'       => $job->employer_id,
            'active'        => true,
        ]);

        $chat               =  Chat::where('user_id', $job->employer_id)->where('job_id',  $request->job_id)->where('employee_id',  Auth::user()->id)->first();
        return response()->json($chat->id);
    }

    public function index()
    {
        $chats = Chat::where('employee_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('employee.chats.index', compact('chats'));
    }

    public function show($id)
    {
        $chat = Chat::find($id);
        return view('employee.chats.show', compact('chat'));
    }

    public function messages(Request $request)
    {
        Message::where('chat_id', $request->chat_id)->where('sender','employer')->update(['seen' => true]);
        $messages = Message::where('chat_id', $request->chat_id)->get();
        $chat     = Chat::find($request->chat_id);
        $html     = view('employee.chats.messages', compact('chat', 'messages'))->render();
        return response()->json($html);
    }

    public function sendMessage(Request $request)
    {
        $chat             = Chat::find($request->chat_id);

        $message          = new Message();
        $message->chat_id = $chat->id;
        $message->message = $request->message;
        $message->sender  = 'employee';
        $message->reciever_id  = $chat->user_id;
        $message->seen    = false;
        $message->save();

        return response()->json([
            'success' => 'Message saved successfully',
        ]);
    }

    public function getUnseenMessage(Request $request)
    {
        $message          = Message::where('sender','employer')
                                     ->where('seen',false)
                                     ->where('reciever_id',Auth::user()->id)
                                     ->count();
        return response()->json([
            'message' => $message
        ]);
    }
}
