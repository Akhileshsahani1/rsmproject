@extends('layouts.admin')
@section('title', 'Show Applicants')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                            class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                </div>
                <h4 class="page-title">Show Applicants</h4>
            </div>
        </div>
    </div>
    @include('admin.includes.flash-message')
    <!-- end page title -->
    <div class="row">
        <div class="col-12">

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
                        <h4 class="mb-0"><a href="{{ route('admin.jobs.show', $job->id) }}" class="text-dark">{{ $job->position_name }}</a></h4>
                        <p class="text-muted"><span class="companyname">{{ $job->employer->company_name }}</span></p>
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
                <p class="text-muted posted-on text-end"><small>Posted: {{ $job->created_at->diffForHumans() }}</small></p>
                            <!-- end card-body-->
                        <!-- end col -->
            </div> <!-- end row-->
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

                    <h4 class="mb-0"><a href="{{ route('admin.jobs.view.applicant', $appliedjob->id)}}" class="text-dark">{{ $appliedjob->employee->firstname }} {{ $appliedjob->employee->lastname }}</a></h4>
                    <p class="text-muted"><span class="companyname">{{ $appliedjob->employee->preferredclassification->classification }} <i class="mdi mdi-arrow-right"> </i><span class="companyname">{{ $appliedjob->employee->preferredsubclassification->sub_classification }}</span></p>
                </div>
                <div class="eployee-contact">
                    <div class="app-openingtotal"><i class="mdi mdi-email"></i> <span>{{ $appliedjob->employee->email }}</span></div>
                    <div class="app-openingtotal"><i class="mdi mdi-phone"></i><span>{{ $appliedjob->employee->phone }}</span></div>
                    <div class="app-openingtotal"><i class="uil-graduation-hat"></i><span>{{ $appliedjob->employee->highest_education }}</span></div>
                </div>
                <div class="skill-badge">
                    @if($appliedjob->employee->job_skill)
                    @foreach ($appliedjob->employee->job_skill as $skill)
                    <span class="badge badge-outline badge-pill">{{ $skill }}</span>
                    @endforeach
                    @endif
                </div>
                <div class="text-muted job-description">
                    {{ $appliedjob->employee->description }}
                </div>
                <div class="cta-button">
                    @if($appliedjob->status == 'applied')
                    @else
                    @if($appliedjob->status == 'accepted')
                    <a href="javascript:void(0)" class="btn badge-success" disabled>Accepted</a>
                    @endif
                    @if($appliedjob->status == 'rejected')
                    <a href="javascript:void(0)" class="btn badge-danger" disabled>Rejected</a>
                    @endif
                    @endif
                </div>
                <p class="text-muted text-end"><small>Applied: {{ $appliedjob->created_at->diffForHumans() }}</small></p>
            </div> <!-- end row-->
            @empty
            <p class="text-center py-5">
                No Applicant found.
            </p>
            @endforelse
        </div>
    </div>
</div> <!-- container -->


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
@endpush
