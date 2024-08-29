@extends('layouts.employer')
@section('title', 'View Applicants')
@section('content')
<h5 class="page-title">Job Details</h5>
    <div class="JobList">
        <div class="box-content">
            <span class="company-logo">
                @if ($job->employer->thumbnail)
                    <img src='{{ asset('storage/uploads/employer/' . $job->employer->thumbnail . '') }}'
                        alt="{{ $job->employer->company_name }}" clas="card-img">
                @else
                    <img src="{{ asset('assets/images/JobIMG.svg') }}" alt="Job Title" clas="card-img">
                @endif
            </span>
                @if (Auth::guard('employee')->user())
                    <img src="{{ asset('assets/images/icons/tag.png') }}" class="float-end"
                        alt="">
                @endif
                <div class="location-group">
                    <h4 class="mb-0"><a href="{{ route('frontend.job.show', $job->id) }}" class="text-dark">{{ $job->position_name }}</a></h4>
                    <p>{{ $job->employer->company_name }}</p>
                    <h6><i class="mdi mdi-map-marker"></i> {{ $job->subzone->name }}, {{ $job->area->name }} {{ $job->region->name }}</h6>
                </div>
        </div>
            <div class="openings mb-2 mt-2">
                <span class="openingtotal"><img src="{{ asset('assets/images/icons/users.svg') }}"
                        alt="Users"> Openings <b>{{ $job->no_of_position }}</b></span>
                <span class="salary"><img src="{{ asset('assets/images/icons/dollar.svg') }}"
                        alt="Users"> ${{ $job->salary_from }} - ${{ $job->salary_upto }} /
                    Month</span>
            </div>
            <div class="text-muted job-description">
                {!! Str::limit($job->description, 196, ' ...') !!} @if(Str::length($job->description) > 196 ) <a class="view_more"
                    long="{!! $job->description !!}" short="{!! Str::limit($job->description, 196, ' ...') !!}">View
                    more</a>
                    @endif
            </div>
            <p class="text-muted posted-on text-end"><small>Posted:
                    {{ $job->created_at->diffForHumans() }}</small></p>
    </div>

     <h5 class="page-title">Job Applicants</h5>

        @forelse ($job->appliedjobs as $appliedjob)

        <div class="JobList">
            <div class="box-content">
                <span class="company-logo">
                    @if ($appliedjob->employee->avatar)
                        <img src='{{   asset('storage/uploads/employees/'.$appliedjob->employee->slug.'/avatar'.'/'.$appliedjob->employee->avatar) }}'
                            alt="{{ $appliedjob->employee->firstname.' '.$appliedjob->employee->lastname }}" clas="card-img">
                    @else
                        <img src="{{ asset('assets/images/applicant-placeholder.svg') }}" alt="Job Title" clas="card-img">
                    @endif
                </span>

                @if (Helper::employeeBookmarkExist($appliedjob->employee->id, Auth::user()->id))
                    <a href="{{ route('employee.bookmark', $appliedjob->employee->id) }}"><img
                            src="{{ asset('assets/images/icons/tag-active.png') }}" class="float-end"
                            alt=""></a>
                @else
                    <a href="{{ route('employee.bookmark', $appliedjob->employee->id) }}"><img
                            src="{{ asset('assets/images/icons/tag.png') }}" class="float-end"
                            alt=""></a>
                @endif
                <h4 class="mb-0"><a href="{{ route('view.applicant', $appliedjob->id)}}" class="text-dark">{{ $appliedjob->employee->firstname }} {{ $appliedjob->employee->lastname }}</a></h4>
                <p class="text-muted"><span
                    class="companyname">{{ $appliedjob->employee->preferredclassification->classification }} <i class="mdi mdi-arrow-right"> </i><span class="companyname">{{ $appliedjob->employee->preferredsubclassification->sub_classification }}</span></p>
            </div>
            <div class="eployee-contact">
                <div class="app-openingtotal"><i class="mdi mdi-email"></i> <span>{{ $appliedjob->employee->email }}</span></div>
                <div class="app-openingtotal"><i class="mdi mdi-phone"></i> <span>{{ $appliedjob->employee->phone }}</span></div>
                <div class="app-openingtotal"><i class="uil-graduation-hat"> </i><span>{{ $appliedjob->employee->highest_education }}</span></div>
            </div>
            <div class="skill-badge">
                @if( isset($appliedjob->employee->job_skill) )
                @foreach ($appliedjob->employee->job_skill as $skill)
                <span class="badge badge-outline badge-pill">{{ $skill }}</span>
                @endforeach
                @endif
            </div>
            <div class="text-muted job-description">
                {!! $appliedjob->employee->description !!}
            </div>
            <div class="cta-button text-center">
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="initiateChat({{ $appliedjob->employee_id }})">Contact</a>
                @php $document = Helper::documentRequestExist($job->id, $appliedjob->employee_id)@endphp
                @if ($document)
                  @if($document->status == 'accepted')
                  <a href="{{ route('employee.documents',$document->employee_id) }}" class="btn btn-outline-success">View Document</a>
                  @elseif($document->status == 'rejected')
                  <a href="javascript:void(0)" class="btn btn-outline-danger">Document Rejected</a>
                  @else
                    <a href="javascript:void(0)" class="btn btn-outline-primary">Document Requested</a>
                    @endif
                @else
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="requestDocument({{ $appliedjob->employee_id }}, {{ $job->id }})">Document</a>
                @endif
                <a href="javascript:void(0)" class="btn btn-outline-primary" style="display: none;">White List</a>
                @if($appliedjob->status == 'applied')
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="approveApplication({{ $appliedjob->id }})">Accept</a>
                <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="rejectApplication({{ $appliedjob->id }})">Reject</a>
                @else
                @if($appliedjob->status == 'accepted')
                <a href="javascript:void(0)" class="btn btn-outline-primary" disabled>Accepted</a>
                @endif
                @if($appliedjob->status == 'rejected')
                <a href="javascript:void(0)" class="btn btn-outline-primary" disabled>Rejected</a>
                @endif
                @endif
            </div>
            <p class="text-muted posted-on text-end"><small>Applied: {{ $appliedjob->created_at->diffForHumans() }}</small></p>
        </div>
        @empty
        <p class="text-center py-5">
            No Applicant found.
        </p>
        @endforelse
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
                        job_id: '{{ $job->id }}',
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
@endpush
