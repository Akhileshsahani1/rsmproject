@extends('layouts.employer')
@section('title', $employee->firstname . ' ' . $employee->lastname)
@section('content')
    <section class="view_applicant">
        <div class="card">
            <div class="card-header">
                <div class="thumb-image">
                    <img src='{{ $employee->avatar }}' alt="{{ $employee->firstname . ' ' . $employee->lastname }}" clas="card-img">
                </div>
            </div>
            <div class="card-body">
                <div class="JobDetails">
                    <h4 class="jobtitle">{{ $employee->firstname . ' ' . $employee->lastname }}</h4>
                    <span class="companyname">{{ $employee->preferredclassification->classification }} <i class="mdi mdi-arrow-right"> </i><span class="companyname">{{ $employee->preferredsubclassification->sub_classification }}</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="cta-button">
                            <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="initiateChat({{ $applied_job->employee_id }})">Contact</a>
                            @if (Helper::documentRequestExist($applied_job->job_id, $applied_job->employee_id))
                            <a href="javascript:void(0)" class="btn btn-outline-primary">Document Requested</a>
                            @else
                            <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="requestDocument({{ $applied_job->employee_id }}, {{ $applied_job->job_id }})">Document</a>
                            @endif
                            <a href="javascript:void(0)" class="btn btn-outline-primary" style="display: none;">White List</a>
                            @if($applied_job->status == 'applied')
                            <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="approveApplication({{ $applied_job->id }})">Accept</a>
                            <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="rejectApplication({{ $applied_job->id }})">Reject</a>
                            @else
                            @if($applied_job->status == 'accepted')
                            <a href="javascript:void(0)" class="btn btn-outline-primary" disabled>Accepted</a>
                            @endif
                            @if($applied_job->status == 'rejected')
                            <a href="javascript:void(0)" class="btn btn-outline-primary" disabled>Rejected</a>
                            @endif
                            @endif
                        </div>
                        <div class="JobPosted">
                            <span class="postedago">Applied: {{ $applied_job->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="appliant_details">
        <div class="card-body">
            <div class="JobDetails">
                <h4 class="jobtitle">Personal Details</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mt-2">
                            <label><strong>Email Address</strong></label>
                            <p>{{ $employee->email }}</p>
                        </div>
                        <div class="form-group mt-3">
                            <label><strong>Phone Number</strong></label>
                            <p>{{ $employee->phone }}</p>
                        </div>
                        <div class="form-group mt-3">
                            <label><strong>Gender</strong></label>
                            <p>{{ $employee->gender }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mt-2">
                            <label><strong>Email Address (Additional)</strong></label>
                            <p>{{ $employee->email_additional }}</p>
                        </div>
                        <div class="form-group mt-3">
                            <label><strong>Nationality</strong></label>
                            <p>{{ $employee->nationality }}</p>
                        </div>
                        <div class="form-group mt-3">
                            <label><strong>External Links</strong></label>
                            <p>{{ $employee->external_link }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body mt-3">
            <div class="JobDetails">
                <h4 class="jobtitle">About</h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>Preferred classification</strong></label>
                            <p>{{ $employee->preferredclassification->classification }}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>Sub-classification</strong></label>
                            <p>{{ $employee->preferredsubclassification->sub_classification }}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>Highest Education</strong></label>
                            <p>{{ $employee->highest_education }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group mt-2">
                            <label><strong>Job Skills</strong></label>
                            <div class="skill-badge">
                                @foreach ($employee->job_skill as $skill)
                                <span class="badge badge-outline badge-pill">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group mt-2">
                            <label><strong>Personal summary</strong></label>
                            {!! $employee->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body mt-3">
            <div class="JobDetails">
                <h4 class="jobtitle">Contact Details</h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>Address</strong></label>
                            <p>{{ $employee->address }}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>City</strong></label>
                            <p>{{ $employee->city }}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>State</strong></label>
                            <p>{{ $employee->state }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>Country</strong></label>
                            <p>Singapore</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mt-2">
                            <label><strong>Zipcode</strong></label>
                            <p>{{ $employee->zipcode }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function approveApplication(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Approve Application!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("job.accept", ":id") }}';
                url = url.replace(':id', id);
                window.location.href = url;
               }
            })
        }
    </script>
    <script>
        function rejectApplication(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Reject Application!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("job.reject", ":id") }}';
                url = url.replace(':id', id);
                window.location.href = url;
               }
            })
        }
    </script>
     <script>
        function initiateChat(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to chat with this employee!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Initiate Chat!"
            }).then(t => {
               if(t.isConfirmed){
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });
                    var formData = {
                        employee_id: id,
                        job_id: '{{ $applied_job->job_id }}',
                    };
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("initiate-chat") }}',
                        data: formData,
                        dataType: 'json',
                        beforeSend: function () {
                            console.log('Before Sending Request');
                        },
                        success: function (res, status) {
                            var url = '{{ route("chats.show", ":id") }}';
                            url = url.replace(':id', res);
                            window.location.href = url;
                        },
                        error: function (res, status) {
                            console.log(res);
                        }
                    });

               }
            })
        }
    </script>
     <script>
        function requestDocument(id, job_id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Request Document!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("employee.request-document", ["id" => ":id", "job_id" => ":job_id"]) }}';
                url = url.replace(':id', id);
                url = url.replace(':job_id', job_id);
                window.location.href = url;
               }
            })
        }
    </script>
    @endpush
