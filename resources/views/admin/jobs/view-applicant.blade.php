@extends('layouts.admin')
@section('title', 'View Applicant')
{{-- @section('head')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
@endsection --}}
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
                <h4 class="page-title">View Applicant</h4>
            </div>
        </div>
    </div>
    @include('admin.includes.flash-message')
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
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
                                    @if($applied_job->status == 'applied')
                                    @else
                                    @if($applied_job->status == 'accepted')
                                    <a href="javascript:void(0)" class="btn badge-success" disabled>Accepted</a>
                                    @endif
                                    @if($applied_job->status == 'rejected')
                                    <a href="javascript:void(0)" class="btn badge-danger" disabled>Rejected</a>
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
                                        @if($employee->job_skill)
                                        @foreach ($employee->job_skill as $skill)
                                        <span class="badge badge-outline badge-pill">{{ $skill }}</span>
                                        @endforeach
                                        @else
                                        <p class="text-center py-4">No Skill Found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mt-2">
                                    <label><strong>Personal summary</strong></label>
                                    <p>{!! $employee->description !!}</p>
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
        </div>
    </div>
</div>
@endsection
