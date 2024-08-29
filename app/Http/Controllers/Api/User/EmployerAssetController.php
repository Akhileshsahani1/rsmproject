<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Job;
use App\Models\ApplyJob;
use App\Models\DocumentRequest;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactUs;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Employee\DocRequest as EmployeeDocRequest;
use Carbon\Carbon;

class EmployerAssetController extends Controller
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

                if ($notify->type == 'App\Notifications\Employer\NewApplication') {

                    $notices[] = [

                        'n'     => 'new job application received from ' . $notify->data['name'],
                        'title' =>  'New Application',
                        'id'    =>  $notify->data['job_id'],
                        'time'  =>  $notify->created_at->diffForHumans()
                    ];
                }
                // if ($notify->type == 'App\Notifications\Employer\DocRequest') {
                //     $notices[] = [

                //         'n'    =>  'Document requested from '. $notify->data['name'],
                //         'title' =>  'Document Request Placed',
                //         'id'   =>  $notify->data['job_id'],
                //         'time' =>  $notify->created_at->diffForHumans()
                //     ];
                // }
                if ($notify->type == 'App\Notifications\Employer\DocRespond') {
                    $notices[] = [

                        'n'    =>  'Document ' . $notify->data['status'] . ' from ' . $notify->data['name'],
                        'title' =>  'Document Respond',
                        'id'   =>  $notify->data['job_id'],
                        'time' =>  $notify->created_at->diffForHumans()
                    ];
                }

                if ($notify->type == 'App\Notifications\Employer\JobStatus') {
                    $notices[] = [

                        'n'    => 'Job  assigned to ' . $notify->data['name'] . ' is ' . $notify->data['status'],
                        'title' => 'Job Assigned',
                        'id'   =>  $notify->data['job_id'],
                        'time' =>  $notify->created_at->diffForHumans()
                    ];
                }

                if ($notify->type == 'App\Notifications\Employer\JobClosed') {

                    $notices[] = [

                        'n'    => 'The listed Job has been closed.',
                        'title' =>  'Job Closed',
                        'id'   =>  $notify->data['job_id'],
                        'time' =>  $notify->created_at->diffForHumans()
                    ];
                }

                if ($notify->type == 'App\Notifications\Employer\ApprovalNotification') {
                    $notices[] = [

                        'n'    => 'Your job has been approved.',
                        'title' =>  'Job Approved',
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
        $chats = Chat::where('user_id', $id)->with('employee', 'job', 'recentmessage')->orderBy('updated_at', 'DESC')->paginate(10);
        if (isset($chats)) {
            foreach ($chats as $k => $chat) {
                if (isset($chat->employee)) {
                    $chat->employee->thumbnail = is_null($chat->employee->avatar) ? asset('assets/images/users/avatar-2.jpg') : asset('storage/uploads/employee/' . $chat->employee->slug . '/' . $chat->employee->avatar . '');
                }
                $chat->unseen = Message::where([
                    'chat_id' => $chat->id,
                    'sender'  => 'employee',
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
        Message::where('chat_id', $request->chat_id)->where('sender', 'employee')->update(['seen' => true]);
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
        $message->sender  = 'employer';
        $message->reciever_id  = $chat->employee_id;
        $message->seen    = false;
        $message->save();

        return response()->json([
            'success' => 'Message saved successfully',
        ]);
    }

    public function sendQuery(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required',
            'phone_number'  => 'required',
            'message'       => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->messages()]);
        }

        $admin = Administrator::find(1);
        Notification::route('mail', $admin->email)->notify(new ContactUs($request->message, $request->email, $request->name, $request->phone_number));

        return response()->json([
            'status_code' => 200,
            'message' => 'Thank you for contacting us. We will reach you shortly.'
        ]);
    }
    public function getAwardedEmployees(){
        $id = Auth::user()->id;
        $jobs = Job::where('employer_id',$id)->pluck('id');
        $employees = ApplyJob::with('employee')->whereIn('job_id' , $jobs)->where('status','accepted')->groupBy('employee_id')->get();
        $employees     = $employees->map(function($e) {
                return [
                    'employee_id'       => $e->employee->id,
                    'name'              => $e->employee->firstname.' '.$e->employee->lastname,
                ];
            });
         return response()->json([
            'employees' => $employees
        ]);
    }

    public function docRequest(Request $request){

        $exists = DocumentRequest::where('employee_id', $request->id)->where('job_id', $request->job_id)->exists();
        if($exists){
            $document_request = DocumentRequest::where('employee_id', $request->id)->where('job_id', $request->job_id)->first();
        }else{
            DocumentRequest::create([
                'employee_id' => $request->id,
                'job_id'      => $request->job_id
            ]);
        }
        $employee = Employee::find($request->id);
        //Auth::user()->notify( new DocRequest( $employee , $job_id));
        $employee->notify( new EmployeeDocRequest( $request->job_id, 'requested'));

        return response()->json(['message' => 'Document requested successfully']);
    }

    public function getEmployeeTimings(Request $request){

        $employee_id = $request->employee_id;
        $id = Auth::user()->id;

        $attendances = Attendance::where('employer_id',$id)
                                   ->where('employee_id',$employee_id)
                                   ->orderBy('updated_at','DESC')
                                   ->paginate(10);
         $attendances   = $attendances->through(function ($a) {
            return [
                'id'                => $a->id,
                'check_in'          => $a->clock_in,
                'check_out'         => $a->clock_out,
                'status'            => $a->status,
                'job'               => $a->job->position_name,
                'company'           => $a->employer->company_name,
                'date_added'        => Carbon::parse($a->date)->format('M d,Y'),
            ];
        });
        return response()->json([
            'attendances' => $attendances
        ]);

    }
    public function updateEmployeeTiming(Request $request){

        Attendance::find($request->attendance_id)->update(['status' => $request->status]);
        $message =  'Attendance Status Changed to '. ucfirst($request->status) .' Successfully.';
        return response()->json([
            'message' => $message,
        ]);
    }
    public function intiateChat(Request $request){
        
       $c = Chat::updateOrCreate(
            [
                'job_id'        => $request->job_id,
                'employee_id'   => $request->id,
                'user_id'       => Auth::user()->id,
            ],
            [
            'job_id'        => $request->job_id,
            'employee_id'   => $request->id,
            'user_id'       => Auth::user()->id,
            'active'        => true,
            ]
        );

        $chat = Chat::where([
            'user_id' => Auth::user()->id,
            'employee_id' => $request->id,
            'job_id'     => $request->job_id
        ]
        )->with('employee', 'job', 'recentmessage')->first();

        if (isset($chat)) {
    
                if (isset($chat->employee)) {
                    $chat->employee->thumbnail = is_null($chat->employee->avatar) ? asset('assets/images/users/avatar-2.jpg') : asset('storage/uploads/employee/' . $chat->employee->slug . '/' . $chat->employee->avatar . '');
                }
                $chat->unseen = Message::where([
                    'chat_id' => $chat->id,
                    'sender'  => 'employee',
                    'seen'    => false
                ])->count();
        }

         return response()->json([
            'chat' => $chat
        ]);
    }
}
