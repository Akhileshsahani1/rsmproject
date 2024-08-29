@extends('layouts.app')
@section('title', $job->position_name)
@section('content')
    <section class="jobsearch">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="searchCaption">
                        <div class="search-form destop-view">
                            <form action="{{ route('frontend.jobs') }}" method="GET">
                                <div class="input-group">
                                    <span class="input-group-text searchjob"><img
                                            src="{{ asset('assets/images/icons/search.svg') }}" alt="search"></span>
                                    <input type="text" class="form-control inputstylesearch"
                                        placeholder="Enter job title, position, skills…" name="position_name">
                                    <span class="input-group-text"><img
                                            src="{{ asset('assets/images/icons/location.svg') }}" alt="search"></span>
                                    <input type="text" class="form-control inputstylesearch" placeholder="Location" name="address">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="search-form mobile-view">
                            <form action="{{ route('frontend.jobs') }}" method="GET">
                                <div class="input-group mb-2">
                                    <span class="input-group-text searchjob"><img
                                            src="{{ asset('assets/images/icons/search.svg') }}" alt="search"></span>
                                    <input type="text" class="form-control inputstylesearch"
                                        placeholder="Enter job title, position, skills…" name="position_name">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><img src="{{ asset('assets/images/icons/location.svg') }}"
                                            alt="search"></span>
                                    <input type="text" class="form-control inputstylesearch" placeholder="Location"
                                        name="address">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="jobdetailpage">
        <div class="container">

            @if(!Auth::guard('web')->check())
            <div class="apply-now-btn">
                <div class="caption">
                    <h1>{{ $job->position_name }}</h1>
                    <span class="DPost">Date Posted:
                        {{ \Carbon\Carbon::parse($job->created_at)->format('M d, Y') }}</span>
                    <a href="{{ route('login') }}" style="display: none;"><i
                            class="fa-solid fa-arrow-right-to-bracket"></i> Login to View
                        Salary</a>
                </div>
                <div class="applybtn">
                    @if(!empty($job->employeeexist()))
                    <button type="button" class="btn btn-primary" ><i
                        class="fa-regular fa-paper-plane me-1"></i>Applied
                        </button>
                    @else
                    <button type="button" class="btn btn-primary" id="apply-job"><i
                            class="fa-regular fa-paper-plane me-1"></i> <span>Apply
                            Now </span></button>
                    @endif
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-8 col-12">
                    <div class="JDetailLeft">
                        <div class="JobDetail">
                            <h3 class="title">Job Detail</h3>
                            <ul class="list-unstyled">
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Location:</div>
                                        <div class="time">{{ $job->location }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Company:</div>
                                        <div class="time"><a
                                                href="javascript:void(0)">{{ $job->employer->company_name }}</a></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Type:</div>
                                        <div class="time"><a href="javascript:void(0)">{{ $job->position_type }}</a></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Shift:</div>
                                        <div class="time"><a href="javascript:void(0)"
                                                class="shift">{{ $job->shift_type }}</a></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Career Level:</div>
                                        <div class="time">{{ $job->career_level }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Positions:</div>
                                        <div class="time">{{ $job->no_of_position }}</div>
                                    </div>
                                </li>
                                <li style="display: none;">
                                    <div class="jobsdetails">
                                        <div class="txt">Experience:</div>
                                        <div class="time">5 Year</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Expected Salary:</div>
                                        <div class="time">${{ $job->salary_from }} - ${{ $job->salary_upto }}</div>
                                    </div>
                                </li>
                                <li style="display: none;">
                                    <div class="jobsdetails">
                                        <div class="txt">Gender:</div>
                                        <div class="time">{{ $job->gender }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Preferred Classification:</div>
                                        <div class="time">{{ $job->preferredclassification->classification }}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Preferred Sub Classification:</div>
                                        <div class="time">{{ $job->preferredsubclassification->sub_classification }}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Degree:</div>
                                        <div class="time">
                                            <div class="skillTypeBtn">

                                                    <div class="timeslot">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="checkbox" class="btn-check" name="btnradio">
                                                                <span class="forcustom">{{ $job->education }}</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="jobsdetails">
                                        <div class="txt">Apply Before:</div>
                                        <div class="time">
                                            {{ \Carbon\Carbon::parse($job->created_at)->addDays(30)->format('M d, Y') }}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="emailtoF">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#signup-modal"><i
                                        class="fa-regular fa-envelope me-1"></i> Email to Friend</button>
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
                <div class="col-sm-4 col-12">
                    <div class="C_Overview">
                        <h4 class="title">Company Overview</h4>
                        <div class="CompanyJob">
                            <div class="thumb-image">
                                <img src="{{ asset('assets/images/JobIMG.svg') }}" width="70px" height="70px"
                                    alt="Job Title" />
                            </div>
                            <div class="CompanyJobDetails">
                                <h5 class="jobtitle">{{ $job->employer->company_name }}</h5>
                                <div class="openings">
                                    <span class="location"><img src="{{ asset('assets/images/icons/location1.svg') }}"
                                            alt="Location" /> {{ $job->employer->address }} </span>
                                    @php
                                        $positions = \App\Models\Job::where('status', 'approved')
                                            ->where('open', true)
                                            ->where('employer_id', $job->employer_id)
                                            ->sum('no_of_position');
                                    @endphp
                                    <span class="openingtotal"><img src="{{ asset('assets/images/icons/users.svg') }}"
                                            alt="Users" /> Openings <b>{{ $positions }}</b></span>
                                </div>

                            </div>
                        </div>
                        <p>{!! $job->employer->description !!}</p>
                    </div>
                    <div class="RelatedJob">
                        <h5 class="title">Related Jobs</h5>
                        @foreach ($related_jobs as $related_job)
                            <a href="{{ route('frontend.job.show', $related_job->id) }}">
                                <div class="RelatedJobDetails">
                                    <h6 class="jobtitle">{{ $related_job->position_name }}</h6>
                                    <span class="companyname">{{ $related_job->employer->company_name }}</span>
                                    <div class="openings">
                                        <span class="location"><img src="{{ asset('assets/images/icons/location1.svg') }}"
                                                alt="Location"> {{ $related_job->location }}</span>
                                    </div>

                                    <div class="shiftType">
                                        <span class="FullTime">{{ $related_job->position_type }}</span>
                                        <span class="ShiftDay">{{ $related_job->shift_type }}</span>
                                    </div>

                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="RelatedJob Google-Map">
                        <h5 class="title">Google Map</h5>
                        <div class="RelatedJobDetails">
                            <iframe
                                src="https://maps.google.com/maps?q={{ $job->latitude }},{{ $job->longitude }}&hl=es;z=14&output=embed"
                                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Signup modal-->
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                      Refer Job to Friend
                </div>

                <form class="ps-3 pe-3" action="{{ route('frontend.refer.job') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="mb-3">
                        <label for="emailaddress" class="form-label">Email address</label>
                        <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter Email" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Message (Optional)</label>
                        <textarea name="message" rows="3" class="form-control">
                        </textarea>
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Sent</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $("#apply-job").click(function(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you Want to Apply this Job!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Apply Now!"
            }).then(t => {
                t.isConfirmed && (e.preventDefault(), $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('employee.job.apply') }}",
                    data: {
                        job_id: "{{ $job->id }}",
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(e) {
                        Swal.fire({
                            title: "Success",
                            text: "Job applied Successfully",
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        }).then(t => {
                            window.location.reload();
                        })
                    },
                    error: function(httpObj, textStatus) {
                        if (httpObj.status == 401) {
                            window.location =
                                "{{ route('employee.login', ['job_id' => $job->id]) }}";
                        }
                    }
                }))
            })
        });
    </script>
@endpush
