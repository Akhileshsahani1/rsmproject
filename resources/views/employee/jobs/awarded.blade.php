@extends('layouts.employee')
@section('title', 'Awarded Jobs')
@section('content')
<h5 class="page-title">Awarded Jobs</h5>
    @forelse($jobs as $application)

            <div class="JobList">
                <div class="box-content">
                    <span class="company-logo">
                        @if ($application->job->employer->thumbnail)
                            <img src='{{ asset('storage/uploads/employer/' . $application->job->employer->thumbnail . '') }}'
                                alt="{{ $application->job->employer->company_name }}" clas="card-img">
                        @else
                            <img src="{{ asset('assets/images/JobIMG.svg') }}" alt="Job Title" clas="card-img">
                        @endif
                    </span>
                    <div class="location-group">
                        <h4 class="mb-0"><a href="{{ route('frontend.job.show', $application->job->id) }}" class="text-dark">{{ $application->job->position_name }}</a></h4>
                        <p>{{ $application->job->employer->company_name }}</p>
                        <h6><i class="mdi mdi-map-marker"></i> {{ $application->job->subzone->name }}, {{ $application->job->area->name }} {{ $application->job->region->name }}</h6>
                    </div>
                </div>
                    <div class="openings mb-2 mt-2">
                        <span class="openingtotal me-3"><img src="{{ asset('assets/images/icons/users.svg') }}"
                                alt="Users"> Openings <b>{{ $application->job->no_of_position }}</b></span>
                        <span class="salary"><img src="{{ asset('assets/images/icons/dollar.svg') }}"
                                alt="Users"> ${{ $application->job->salary_from }} - ${{ $application->job->salary_upto }} /
                            Month</span>
                    </div>
                    <div class="text-muted job-description">
                        {!! Str::limit($application->job->description, 196, ' ...') !!} <a class="view_more"
                            long="{!! $application->job->description !!}" short="{!! Str::limit($application->job->description, 196, ' ...') !!}">View
                            more</a>
                    </div>
                    <a href="javascript:void(0)" onclick="cancelApplication({{ $application->id }})" class="mt-2 btn btn-sm btn-danger float-start mb-2"><i class="mdi mdi-close me-1"></i>Cancel Application</a>
                    <a href="javascript:void(0)" class="mt-2 btn btn-sm ms-1 btn-secondary" onclick="initiateChat({{ $application->job_id }})">Contact</a>
                    @if(Helper::documentRequestExist($application->job_id, $application->employee_id ))
                        @if(Helper::documentRequestStatus($application->job_id, $application->employee_id ) == 'pending')
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle ms-1" data-bs-toggle="dropdown" aria-expanded="false"><i class="uil-document me-1"></i>Document Requested <span class="caret"></span> </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="acceptDocumentRequest({{ $application->employee_id }}, {{ $application->job_id }})">Accept Request</a>
                                <a class="dropdown-item" href="#" onclick="rejectDocumentRequest({{ $application->employee_id }}, {{ $application->job_id }})">Reject Request</a>
                            </div>
                        @else
                            @if(Helper::documentRequestStatus($application->job_id, $application->employee_id ) == 'accepted')
                            <a href="javascript:void(0)" class="btn btn-sm btn-success ms-1"><i class="uil-document me-1"></i>Document Requested Accepted </a>
                            @else
                            <a href="javascript:void(0)" class="btn btn-sm btn-dark ms-1"><i class="uil-document me-1"></i>Document Requested Rejected </a>
                            @endif
                        @endif
                    @endif
                    <p class="text-muted posted-on text-end"><small>Applied:
                            {{ $application->created_at->diffForHumans() }}</small></p>
            </div>
            @empty
            <p class="text-center py-5">
                No Awarded Job Applications found.
            </p>
            @endforelse
            <div class="mt-1">
                {{ $jobs->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function cancelApplication(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Cancel Application!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("employee.application.cancel", ":id") }}';
                url = url.replace(':id', id);
                window.location.href = url;
               }
            })
        }
    </script>
     <script>
        function acceptDocumentRequest(id, job_id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Accept Document Request!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("employee.accept.request-document", ["id" => ":id", "job_id" => ":job_id"]) }}';
                url = url.replace(':id', id);
                url = url.replace(':job_id', job_id);
                window.location.href = url;
               }
            })
        }
    </script>
    <script>
        function rejectDocumentRequest(id, job_id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Reject Document Request!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("employee.reject.request-document", ["id" => ":id", "job_id" => ":job_id"]) }}';
                url = url.replace(':id', id);
                url = url.replace(':job_id', job_id);
                window.location.href = url;
               }
            })
        }
    </script>
     <script>
        function initiateChat(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to chat with this employer!",
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
                        job_id: id,
                    };
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("employee.initiate-chat") }}',
                        data: formData,
                        dataType: 'json',
                        beforeSend: function () {
                            console.log('Before Sending Request');
                        },
                        success: function (res, status) {
                            var url = '{{ route("employee.chats.show", ":id") }}';
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
@endpush
