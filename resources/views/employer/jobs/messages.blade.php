@foreach ($chat->messages as $message)
    @if($message->sender=='employee')
    <li class="clearfix">
        <div class="chat-avatar">
            <img src="{{ $employee->avatar }}" alt="male">
            <i>{{ Helper::checkTime($message->created_at) }}</i>
        </div>
        <div class="conversation-text">
            <div class="ctext-wrap">
                <i>{{ $employee->firstname }} {{ $employee->lastname }}</i>
                <p>
                    {{ $message->message }}
                </p>
            </div>
        </div>
    </li>
    @else
    <li class="clearfix odd">
        <div class="chat-avatar">
            <img src="{{ $employer->avatar }}" alt="Female">
            <i>{{ Helper::checkTime($message->created_at) }}</i>
        </div>
        <div class="conversation-text">
            <div class="ctext-wrap">
                <i>{{ $employer->owner_name }}</i>
                <p>
                    {{ $message->message }}
                </p>
            </div>
        </div>
    </li>
    @endif
@endforeach

