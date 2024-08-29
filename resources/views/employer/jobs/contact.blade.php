@extends('layouts.employer')

@section('content')
<style>
    body{
        background-color: #ededed;
    }
</style>
<div class="eployee_chat">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end" style="display: none;">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                    <h4 class="header-title mb-3">Applicant Profile</h4>

                    <div class="inbox-widget" >
                        @if($applicant)
                        <div class="inbox-item">
                            @if ($applicant->thumbnail)
                                <div class="inbox-item-img"><img src="{{ asset('storage/uploads/employer/' . $applicant->thumbnail . '') }}" class="rounded-circle" alt=""></div>
                            @else
                            <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="rounded-circle" alt=""></div>
                            @endif

                            <p class="inbox-item-author">{{ $applicant->firstname }} {{ $applicant->lastname }}</p>
                            <p class="inbox-item-text">{{ $applicant->preferredclassification->classification }}</p>

                        </div>
                        @endif
                        {{-- @foreach($chats as $chat)
                            <div class="inbox-item">
                                @if ($chat->employee->thumbnail)
                                    <div class="inbox-item-img"><img src="{{ asset('storage/uploads/employer/' . $chat->employee->thumbnail . '') }}" class="rounded-circle" alt=""></div>
                                @else
                                <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="rounded-circle" alt=""></div>
                                @endif

                                <p class="inbox-item-author">{{ $chat->employee->firstname }} {{ $chat->employee->lastname }}</p>
                                <p class="inbox-item-text">{{ $chat->employee->preferredclassification->classification }}</p>

                            </div>

                        @endforeach --}}

                    </div> <!-- end inbox-widget -->
                </div> <!-- end card-body-->
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">

                    </div>
                    <h4 class="header-title mb-3">Chat</h4>

                    <div class="chat-conversation">
                        <div data-simplebar="init" style="height: 350px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
                            <ul class="conversation-list" style="height:300px; overflow-y:scroll;">



                            </ul>
                        </div></div></div></div><div class="simplebar-placeholder" style="width: 468px; height: 338px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none;"></div></div></div>
                        <form class="needs-validation" novalidate="" name="chat-form" id="chat-form">
                            <div class="row">
                                <input type="hidden" value="{{ $job_id }}" name="job_id" id="form-job-id">
                                <input type="hidden" value="{{ $employee_id }}" name="employee_id" id="employee-job-id">
                                <div class="col">
                                    <textarea class="form-control chat-input" placeholder="Enter your text" rows="1" id="input-message"></textarea>
                                    <div class="invalid-feedback" id="error-message" style="display: none;">
                                        Please enter your messsage
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-danger chat-send waves-effect waves-light" id="form-submit">Send</button>
                                </div>
                            </div>
                        </form>

                    </div> <!-- end .chat-conversation-->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
     $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                $('#error-message').css('display','none');
               let message = $('#input-message').val();
               let job_id =  $('#form-job-id').val();
               let employee_id =$('#employee-job-id').val();
               if(message == ''){
                  $('#error-message').css('display','block');
                  return false
                }
                var formData = new FormData(this);
                formData.append('message', message);
                formData.append('job_id', job_id);
                formData.append('employee_id', employee_id);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('job.message.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: (data) => {
                        this.reset();
                        getMessage(job_id,employee_id);
                    },
                    error: function(data) {

                    }
                });
            });
            function getMessage(job_id,employee_id){
                $.ajax({
                        url: "{{ route('job.message.get') }}",
                        method: "POST",
                        data:{job_id:job_id,employee_id:employee_id},
                        success:function(data){
                            $('.conversation-list').html(data.html);
                    }

                });
            }
            getMessage('{{ $job_id }}','{{ $employee_id }}');
</script>

@endpush
