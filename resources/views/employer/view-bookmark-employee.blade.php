@extends('layouts.employer')
@section('title', 'Bookmarks')
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
    @endpush
