@extends('layouts.employee')
@section('title', 'Inbox')
@section('content')
    <div class="card">
        <div class="card-header bg-blue text-white pb-0">
            <h5 class="card-title mb-0">{{ $chat->employer->company_name ?? '' }}</h5>
            <p><small>{!! Str::limit($chat->job->position_name, 196, ' ...') !!}</small></p>
        </div>
        <div class="card-body">
            <div class="chat-conversation" >
                <div style="height: 350px; overflow-y:scroll;" id="chat-div1">
                    <ul class="conversation-list" id="messages_div">
                        <li class="text-center py-5"><div class="spinner-border text-warning" role="status"></div></li>
                    </ul>
                </div>
                <form name="chat-form" id="chat-form">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control chat-input" placeholder="Enter your message here..." required>
                            <div class="invalid-feedback" style="display: none">
                                Please enter your messsage
                            </div>
                        </div>
                        <div class="col-auto d-grid">
                            <button type="submit" class="btn btn-danger chat-send waves-effect waves-light">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function getMessages(scroll_div = false) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
                }
            });
            var formData = {
                chat_id: '{{ $chat->id }}',
            };
            $.ajax({
                type: 'POST',
                url: '{{ route("employee.chats.messages") }}',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log("Before Loading");
                },
                success: function(res, status) {
                    $('#messages_div').html(res);
                    if(scroll_div) {
                    scrollToBottom('chat-div1');
                   }
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
        const scrollToBottom = (id) => {
            const element = document.getElementById(id);
            element.scrollTop = element.scrollHeight;
        }
    </script>
    <script>
        setInterval(function() {
            getMessages();
        }, 3000);
        getMessages(true);
    </script>
    <script>
        $('#chat-form').submit(function (e) {
            e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
                    }
                });
                var formData = {
                    message: $('.chat-input').val(),
                    chat_id: '{{ $chat->id }}'
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ route("employee.chats.send-message") }}',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        console.log('Before Sending Request');
                    },
                    success: function (res, status) {
                        $('.chat-input').val('');
                        getMessages(true);
                    },
                    error: function (res, status) {
                        console.log(res);
                    }
                });
        });
    </script>
@endpush
