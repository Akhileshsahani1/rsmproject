@extends('layouts.app')
@section('title', 'Welcome to Reliance Service')
@section('content')
    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="banner-caption" id="jobform">
                        <h1>Find the <span>job</span> that fits your life</h1>
                        <p>Healthcare & Medical, Hospitality & Tourism, Marketing & Communication</p>
                    </div>

                    <div class="search-form destop-view">
                        <form action="{{ route('frontend.jobs') }}" method="GET">
                            <div class="input-group mb-3">
                                <span class="input-group-text searchjob"><img
                                        src="{{ asset('assets/images/icons/search.svg') }}" alt="search"></span>
                                <input type="text" class="form-control inputstylesearch"
                                    placeholder="Enter job title, position, skills…" name="position_name">
                                <span class="input-group-text"><img src="{{ asset('assets/images/icons/location.svg') }}"
                                        alt="search"></span>
                                <input type="text" class="form-control inputstylesearch" placeholder="Location"
                                    name="address">
                                {{--  <button type="button" class="btn btn-primary">Search</button>  --}}
                                <button type="submit" class="btn btn-primary">Search</a>
                            </div>

                            <div class="workstype">
                                <select class="form-select Custom-select" name="position"
                                    data-placeholder="Select Position">
                                    <option value="">Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->position_name }}">{{ $position->position_name }}
                                        </option>
                                    @endforeach

                                </select>
                                <select id="preferred_classification"
                                    class="form-select Custom-select @error('preferred_classification') is-invalid @enderror"
                                    name="classification" onchange="getSubclassifications();">
                                    <option value="">Classification</option>
                                    @foreach ($classifications as $classification)
                                        <option value="{{ $classification->id }}"
                                            {{ old('preferred_classification') == $classification->id ? 'selected' : '' }}>
                                            {{ $classification->classification }}</option>
                                    @endforeach
                                </select>
                                <select id="sub_classification" class="form-select Custom-select" name="sub_classification">
                                    <option value="">Sub-classification</option>
                                </select>
                                <select class="form-select Custom-select" name="job_type">
                                    <option value="">Job Type</option>
                                    <option value="Part Time">
                                        Part Time</option>
                                    <option value="Full Time">
                                        Full Time
                                    </option>
                                    <option value="Contract">
                                        Contract</option>
                                    <option value="Casual">
                                        Casual</option>
                                </select>
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


                            <a class="advance-filter" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <i class="uil-sliders-v-alt"></i>Advance Search</a>
                            <div class="collapse navbar-collapse workstype" id="navbarNavDropdown">
                                <select class="form-select Custom-select" name="position"
                                    data-placeholder="Select Position">
                                    <option value="">Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->position_name }}">{{ $position->position_name }}
                                        </option>
                                    @endforeach

                                </select>
                                <select id="preferred_classification"
                                    class="form-select Custom-select @error('preferred_classification') is-invalid @enderror"
                                    name="classification" onchange="getSubclassifications();">
                                    <option value="">Classification</option>
                                    @foreach ($classifications as $classification)
                                        <option value="{{ $classification->id }}"
                                            {{ old('preferred_classification') == $classification->id ? 'selected' : '' }}>
                                            {{ $classification->classification }}</option>
                                    @endforeach
                                </select>
                                <select id="sub_classification" class="form-select Custom-select" name="sub_classification">
                                    <option value="">Sub-classification</option>
                                </select>
                                <select class="form-select Custom-select" name="job_type">
                                    <option value="">Job Type</option>
                                    <option value="Part Time">
                                        Part Time</option>
                                    <option value="Full Time">
                                        Full Time
                                    </option>
                                    <option value="Contract">
                                        Contract</option>
                                    <option value="Casual">
                                        Casual</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-5">
                    <img src="{{ asset('assets/images/bnr.png') }}" class="rounded mx-auto d-block m_image" alt="Moving Banner">
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="four-features">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-6">
                    <div class="first-feature">
                        <h3>25k+</h3>
                        <p>Open job positions</p>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="first-feature">
                        <h3>5M+</h3>
                        <p>Active Employees</p>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="first-feature">
                        <h3>12k+</h3>
                        <p>Companies Jobs</p>
                    </div>
                </div>
                <div class="col-sm-3 col-6">
                    <div class="first-feature">
                        <h3>3k+</h3>
                        <p>Jobs Done</p>
                    </div>
                </div>
            </div>
        </div>

    </section> --}}
    <section class="jobs">
        <div class="container">
            <div class="mr-ai">
                <div>
                    <h2>Most Recent</h2>
                </div>
                <div>
                    <a href="{{ route('frontend.ai-recommendation') }}" class="btn btn-primary">AI Recommendation</a>
                </div>
            </div>
            <div class="row">
                @foreach ($jobs as $job)
                    <div class="col-sm-6">
                        <div class="JobList">
                            <div class="box-content">
                                <span class="company-logo">
                                    @if ($job->employer->avatar)
                                        <img src='{{ asset('storage/uploads/employer/' .$job->employer->slug.'/avatar/'.$job->employer->avatar . '') }}'
                                            alt="{{ $job->employer->company_name }}" clas="card-img">
                                    @else
                                        <img src="{{ asset('assets/images/JobIMG.svg') }}" alt="Job Title" clas="card-img">
                                    @endif
                                </span>
                                @if (Auth::guard('employee')->user())
                                @if(Helper::bookmarkExist($job->id, Auth::guard('employee')->user()->id))
                                    <a href="{{ route('employee.job.bookmark', $job->id) }}"><img src="{{ asset('assets/images/icons/tag-active.png') }}" class="float-end"
                                    alt=""></a>
                                    @else
                                    <a href="{{ route('employee.job.bookmark', $job->id) }}"><img src="{{ asset('assets/images/icons/tag.png') }}" class="float-end"
                                        alt=""></a>
                                    @endif
                                @endif
                                <div class="location-group">
                                    <h4 class="mb-0"><a href="{{ route('frontend.job.show', $job->id) }}" class="text-dark">{{ $job->position_name }}</a></h4>
                                    <p>{{ $job->employer->company_name }}</p>
                                    <h6><i class="mdi mdi-map-marker"></i> {{ $job->subzone->name }}, {{ $job->area->name }} {{ $job->region->name }}</h6>
                                </div>
                            </div>
                            <div class="openings mb-2 mt-2">
                                <span class="openingtotal me-3"><img src="{{ asset('assets/images/icons/users.svg') }}"
                                        alt="Users"> Openings <b>{{ $job->no_of_position }}</b></span>
                                <span class="salary"><img src="{{ asset('assets/images/icons/dollar.svg') }}"
                                        alt="Users"> ${{ $job->salary_from }} - ${{ $job->salary_upto }} / Month</span>
                            </div>
                            <div class="text-muted job-description">
                                {!! Str::limit($job->description, 212, ' ...') !!} <a class="view_more"
                                    long="{!! $job->description !!}" short="{!! Str::limit($job->description, 212, ' ...') !!}">View
                                    more</a>
                            </div>
                            <p class="text-muted posted-on text-end"><small>Posted:
                            {{ $job->created_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--<section class="PostYourJob">
        <div class="container">
            <h2>Post your job for FREE!</h2>
            <div class="row rowmargin">
                <div class="col-sm-6 col-xs-12">
                    <div class="jobimage">
                        <img src="{{ asset('assets/images/jobimgN.png') }}" alt="Job Post" class="img-fluid">
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="jobdetails">
                        <ul class="list-unstyled">
                            <li>
                                <a href="javascript:void(0)">
                                    <div class="jobfree">
                                        <img src="{{ asset('assets/images/icons/createuser.png') }}" alt="user">
                                        <span>Create your account</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <div class="jobfree">
                                        <img src="{{ asset('assets/images/icons/jobpost.png') }}" alt="user">
                                        <span>Post a new job</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <div class="jobfree">
                                        <img src="{{ asset('assets/images/icons/hire.png') }}" alt="user">
                                        <span>Hire an applicant</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="app-caption">
                        <h5>Millions Of Jobs</h5>
                        <h2>Find The One That’s Right For You</h2>
                        <p>Search all the open positions on the web. Get your own personalized salary estimate. Read reviews on over 600,000 companies worldwide. The right job is out there</p>
                        <a href="#jobform" class="btn btn-primary">Search Jobs</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('assets/images/cnr.png') }}" alt="Job Post" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <section class="millions-jobs">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <img src="{{ asset('assets/images/pic3.webp') }}" alt="Job Post" class="img-fluid">
                </div>
                <div class="col-sm-6">
                    <div class="million-caption">
                        <h2>Create and Build Your Attractive Profile</h2>
                        <p>Search all the open positions on the web. Get your own personalized salary estimate. Read reviews on over 600,000 companies worldwide.</p>
                        <ul>
                            <li><i class="mdi mdi-checkbox-marked-circle-outline"></i><span>Bring to the table win-win survival</span></li>
                            <li><i class="mdi mdi-checkbox-marked-circle-outline"></i><span>Capitalize on low hanging fruit to identify</span></li>
                            <li><i class="mdi mdi-checkbox-marked-circle-outline"></i><span>But I must explain to you how all this</span></li>
                        </ul>
                        <a href="{{ route('post-job')}}" class="btn btn-primary">Post A Job</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="app-banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="app-caption">
                        <h5>Download & Enjoy</h5>
                        <h2>Get the RSM Job Search App</h2>
                        <p>Search through millions of jobs and find the right fit. Simply swipe right to apply.</p>
                        <ul>
                            <li><a href="https://www.apple.com/in/app-store/"><img src="{{ asset('assets/images/apple-btn.svg') }}" alt="Job Post" class="img-fluid"></a></li>
                            <li><a href="https://play.google.com/store/apps"><img src="{{ asset('assets/images/google-btn.svg') }}" alt="Job Post" class="img-fluid"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('assets/images/mobile-app.png') }}" alt="Job Post" class="img-fluid two-app">
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        function getSubclassifications() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                }
            });
            var formData = {
                classification_id: $('#preferred_classification').val(),
            };
            $.ajax({
                type: 'POST',
                url: "{{ route('get-sub-classifications') }}",
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log('Before Sending Request');
                },
                success: function(res, status) {
                    $('#sub_classification').html(res);
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>
@endpush
