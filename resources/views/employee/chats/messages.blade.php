
    @forelse ($messages as $message)
        @if ($message->sender == 'employer')
            <li class="clearfix">
                <div class="chat-avatar">
                    @if ($chat->employer->avatar)
                        <img src="{{ asset('storage/uploads/employers/' . $chat->employer->slug . '/' . $chat->employer->avatar . '') }}">
                    @else
                        <img src="{{ asset('assets/images/users/employer-avatar.png') }}" alt="male">
                    @endif
                    
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <i>{{ $chat->employer->company_name ?? '' }}</i>
                        <p>
                            {{ $message->message }}<br><small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            </li>
        @else
            <li class="clearfix odd">
                <div class="chat-avatar">
                    @if ($chat->employee->avatar)
                        <img
                            src="{{ asset('storage/uploads/employees/' . $chat->employee->slug . '/' . $chat->employee->avatar . '') }}">
                    @else
                        <img src="{{ asset('assets/images/users/employee-avatar.png') }}" alt="male">
                    @endif                
                </div>
                <div class="conversation-text">
                    <div class="ctext-wrap">
                        <i><i>{{ $chat->employer->firstname ?? '' }} {{ $chat->employer->lastname ?? '' }}</i></i>
                        <p>
                            {{ $message->message }}<br><small>{{ $message->created_at->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            </li>
        @endif
    @empty
    <li class="text-center py-5">No Messages found.</li>
    @endforelse