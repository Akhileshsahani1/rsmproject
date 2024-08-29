@extends('layouts.admin')
@section('title', 'Show Job')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-sm btn-warning me-1"><i
                                class="fa fa-edit me-1"></i>Edit</a>
                        <a href="javascript:void(0);" onclick="confirmDelete({{ $job->id }})"
                            class="btn btn-sm btn-danger"><i class="fa fa-trash-alt me-1"></i>
                            Delete</a>
                        <form id='delete-form{{ $job->id }}' action='{{ route('admin.jobs.destroy', $job->id) }}'
                            method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                    </div>
                    <h4 class="page-title">Show Job</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <section class="jobdetailpage">
                            <div class="row">
                                <div class="col-sm-8 col-12">
                                    <div class="caption">
                                        <h1>{{ $job->position_name }}</h1>
                                        <span class="DPost">Date Posted:
                                            {{ \Carbon\Carbon::parse($job->created_at)->format('M d, Y') }}</span>
                                        <a href="{{ route('login') }}" style="display: none;"><i
                                                class="fa-solid fa-arrow-right-to-bracket"></i> Login to View
                                            Salary</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-12">
                                    <div class="JDetailLeft">
                                        <div class="JobDetail">
                                            <h3 class="title">Job Detail</h3>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group mt-2">
                                                        <label><strong>Location:</strong></label>
                                                        <p>{{ $job->location }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group mt-2">
                                                        <label><strong>Company:</strong></label>
                                                        <p>{{ $job->employer->company_name }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Type:</strong></label>
                                                        <p>{{ $job->position_type }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Shift:</strong></label>
                                                        <p>{{ $job->shift_type }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Career Level:</strong></label>
                                                        <p>{{ $job->career_level }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Positions:</strong></label>
                                                        <p>{{ $job->no_of_position }}</p>
                                                    </div>
                                                    <div class="form-group mt-2" style="display: none;">
                                                        <label><strong>Experience:</strong></label>
                                                        <p>5 Years</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group mt-2">
                                                        <label><strong>Expected Salary:</strong></label>
                                                        <p>${{ $job->salary_from }} - ${{ $job->salary_upto }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Gender:</strong></label>
                                                        <p>{{ $job->gender }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Preferred Classification:</strong></label>
                                                        <p>{{ $job->preferredclassification->classification }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Preferred Sub Classification:</strong></label>
                                                        <p>{{ $job->preferredsubclassification->sub_classification }}</p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Degree:</strong></label>
                                                        <p>
                                                            <div class="skillTypeBtn">
                                                                <div class="timeslot">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="checkbox" class="btn-check"
                                                                                name="btnradio">
                                                                            <span
                                                                                class="forcustom">{{ $job->education }}</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label><strong>Apply Before:</strong></label>
                                                        <p>{{ \Carbon\Carbon::parse($job->created_at)->addDays(30)->format('M d, Y') }}</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="JobDetail">
                                            <h3 class="title">Job Description</h3>
                                            {!! $job->description !!}

                                        </div>
                                        <div class="JobDetail">
                                            <h3 class="title">Benefits</h3>

                                            {!! $job->benefits !!}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div class="C_Overview">
                                        <h4 class="title">Company Overview</h4>
                                        <div class="CompanyJob">
                                            <div class="thumb-image">
                                                <img src="{{ asset('assets/images/JobIMG.svg') }}" width="70px"
                                                    height="70px" alt="Job Title" />
                                            </div>
                                            <div class="CompanyJobDetails">
                                                <h5 class="jobtitle">{{ $job->employer->company_name }}</h5>
                                                <div class="openings">
                                                    <span class="location"><img
                                                            src="{{ asset('assets/images/icons/location1.svg') }}"
                                                            alt="Location" /> {{ $job->employer->address }} </span>
                                                    @php
                                                        $positions = \App\Models\Job::where('open', true)
                                                            ->where('employer_id', $job->employer_id)
                                                            ->sum('no_of_position');
                                                    @endphp
                                                    <span class="openingtotal"><img
                                                            src="{{ asset('assets/images/icons/users.svg') }}"
                                                            alt="Users" /> Openings
                                                        <b>{{ $positions }}</b></span>
                                                </div>

                                            </div>
                                        </div>
                                        <p>{!! $job->employer->description !!}</p>
                                    </div>
                                    <div class="RelatedJob Google-Map">
                                        <h5 class="title">Google Map</h5>
                                        <div class="RelatedJobDetails">
                                            <iframe
                                                src="https://maps.google.com/maps?q={{ $job->latitude }},{{ $job->longitude }}&hl=es;z=14&output=embed"
                                                width="100%" height="250" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-12">
                                    <div class="JobDetail">
                                        <h4 class="title">Skills Required</h4>
                                        <div class="skillTypeBtn">
                                            @foreach ($job->skills_required as $skill)
                                                <div class="timeslot">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="checkbox" class="btn-check" name="btnradio">
                                                            <span class="forcustom">{{ $skill }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div> <!-- container -->


@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && document.getElementById("delete-form" + e).submit()
            })
        }
    </script>
@endpush
