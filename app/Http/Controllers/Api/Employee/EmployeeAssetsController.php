<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Attendance;
use App\Models\Chat;
use App\Models\Job;
use App\Models\Message;
use App\Notifications\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeAssetsController extends Controller
{
    public function notifications(Request $request)
    {

        $notifications = auth()->user()->notifications()
            ->orderBy('read_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(20)->get();

        $notices = [];

        if (isset($notifications)) {
            foreach ($notifications as $notify) {

                if ($notify->type == 'App\Notifications\Employee\JobStatus') {

                    $notices[] = [

                        'n'    => 'Applied job has been ' . $notify->data['status'],
                        'id'   =>  $notify->data['job_id'],
                        'time' =>  $notify->created_at->diffForHumans()
                    ];
                }
                if ($notify->type == 'App\Notifications\Employee\DocRequest') {
                    $notices[] = [

                        'n'    =>  'Document request is received for job',
                        'id'   =>  $notify->data['job_id'],
                        'time' =>  $notify->created_at->diffForHumans()
                    ];
                }
                if ($notify->type == 'App\Notifications\Employee\NewJobPostingNotification') {
                    $notices[] = [

                        'n'    => 'New job has posted based on your skills.',
                        'id'   =>  $notify->data['job_id'],
                        'time' =>  $notify->created_at->diffForHumans()
                    ];
                }
            }
        }

        return response()->json([
            'notifications' => $notices
        ]);
    }

    public function markReadAll()
    {
        foreach (Auth::user()->unreadNotifications as $notification) {

            $notification->markAsRead();
        }
        return response()->json(['success' => 'notification marked successfully']);
    }

    public function bellNotice()
    {

        $notifications = auth()->user()->notifications()
            ->where('read_at', null)
            ->orderBy('read_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(20)->get();

        return response()->json([
            'notice' => $notifications
        ]);
    }

    public function chatList()
    {

        $id = Auth::user()->id;
        $chats = Chat::where('employee_id', $id)->with('employer', 'job', 'recentmessage')->orderBy('updated_at', 'DESC')->paginate(10);
        if (isset($chats)) {
            foreach ($chats as $k => $chat) {
                if (isset($chat->employer)) {
                    $chat->employer->thumbnail = is_null($chat->employer->avatar) ? asset('assets/images/users/avatar-2.jpg') : asset('storage/uploads/employers/' . $chat->employer->slug . '/' . $chat->employer->avatar . '');
                }
                $chat->unseen = Message::where([
                    'chat_id' => $chat->id,
                    'sender'  => 'employer',
                    'seen'    => false
                ])->count();
            }
        }

        return response()->json([
            'chats' => $chats
        ]);
    }

    public function readMessages(Request $request)
    {
        Message::where('chat_id', $request->chat_id)->where('sender', 'employer')->update(['seen' => true]);
        return response()->json([
            'message' => 'Message marked as read'
        ]);
    }

    public function messages(Request $request)
    {

        $messages = Message::where('chat_id', $request->chat_id)->get();
        return response()->json([

            'messages' => $messages
        ]);
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

    public function addAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'job_id' => ($request->type == 'clockin') ? 'required' : '',
            'id'   => ($request->type == 'clockout') ? 'required' : '',
        ], [
            'job_id.required' => 'Please select job'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }
        $job = Job::find($request->job_id);
        if ($request->type == 'clockin') {

            $attendance = new Attendance;

            $attendance->employee_id = Auth::user()->id;
            $attendance->employer_id = $job->employer_id;
            $attendance->job_id = $request->job_id;
            $attendance->date = Carbon::now()->format('d-m-Y');
            $attendance->clock_in = Carbon::now()->format('h:i:s a');
            $attendance->status = 'pending';
            $attendance->save();

            $message = 'Check in successfully recorded';
        }

        if ($request->type == 'clockout') {
            Attendance::where('id', $request->id)->update([
                'clock_out' => Carbon::now()->format('h:i:s a')
            ]);

            $message = 'You\'r now checked out';
        }

        return response()->json([
            'message' => $message
        ]);
    }

    public function attendance()
    {

        $attendance = Attendance::where('employee_id', Auth::user()->id)->with('job','job.employer')->orderBy('updated_at', 'DESC')->paginate(8);
        $latest = (isset($attendance)) ?  $attendance[0] : null;
        $run = false;
        if (isset($attendance)) {
            foreach ($attendance as $attend) {


                if (empty($attend->clock_out)) {

                    $attend->run = true;
                    $run = true;

                } else {

                    $cin = Carbon::parse($attend->clock_in);
                    $cout = Carbon::parse($attend->clock_out);

                    $diff = $cout->diffInSeconds($cin);

                    $attend->difference = gmdate('H:i:s', $diff);
                }
            }
        }
        return response()->json([
            'attendance' => $attendance,
            'run' => $run,
            'latest' => $latest
        ]);
    }
}
