<?php

namespace App\Http\Controllers\Employer;

use App\Models\Chat;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'employer-approved']);
    }

    public function initiate(Request $request)
    {
        Chat::updateOrCreate([
            'job_id'        => $request->job_id,
            'employee_id'   => $request->employee_id,
            'user_id'       => Auth::user()->id,
            'active'        => true,
        ]);

        $chat               =  Chat::where('user_id', Auth::user()->id)->where('job_id',  $request->job_id)->where('employee_id',  $request->employee_id)->first();
        return response()->json($chat->id);
    }

    public function index()
    {

        $chats = Chat::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return view('employer.chats.index', compact('chats'));
    }

    public function show($id)
    {
        $chat = Chat::find($id);
        return view('employer.chats.show', compact('chat'));
    }

    public function messages(Request $request)
    {
        Message::where('chat_id', $request->chat_id)->where('sender','employee')->update(['seen' => true]);
        $messages = Message::where('chat_id', $request->chat_id)->get();
        $chat     = Chat::find($request->chat_id);
        $html     = view('employer.chats.messages', compact('chat', 'messages'))->render();
        return response()->json($html);
    }

    public function sendMessage(Request $request)
    {
        $chat             = Chat::find($request->chat_id);

        $message          = new Message();
        $message->chat_id = $chat->id;
        $message->message = $request->message;
        $message->sender  = 'employer';
        $message->reciever_id  = $chat->employee_id;
        $message->seen    = false;
        $message->save();

        return response()->json([
            'success' => 'Message saved successfully',
        ]);
    }

    public function getUnseenMessage(Request $request)
    {
        $message          = Message::where('sender','employee')
                                     ->where('seen',false)
                                     ->where('reciever_id',Auth::user()->id)
                                     ->count();
        return response()->json([
            'message' => $message
        ]);
    }
}
