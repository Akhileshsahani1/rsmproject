@extends('layouts.employer')
@section('title', 'My Profile')
@section('head')
    <link href="{{ asset('assets/css/vendor/cropper.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<h5 class="page-title">Company Details</h5>
<section class="view_applicant">
    <div class="card">
        <div class="card-header">
            <div class="thumb-image">
                <img src="{{ $employer->avatar }}" class="avatar-lg img-thumbnail" alt="profile-image">
            </div>
            <div class="edit-companany">
                <a href="{{ route('edit-profile') }}" class="btn btn-outline"><i class="fa fa-edit me-1"></i> Edit</a>
                <p>Date Joined : {{ \Carbon\Carbon::parse($employer->created_at)->format('l, M d h:i A') }}</p>
            </div>

        </div>
        <div class="card-body">
            <h4 class="jobtitle">{{ $employer->owner_name }}</h4>
            <span class="companyname">{{ __('Employer') }}</span>
        </div>
    </div>
</section>
<section class="appliant_details mb-5">
    <div class="card-body">
        <div class="JobDetails">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mt-2">
                        <label><strong>Company Name</strong></label>
                        <p>{{ $employer->company_name }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Fullname</strong></label>
                        <p>{{ $employer->owner_name }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Email</strong></label>
                        <p>{{ $employer->email }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Email (Additional)</strong></label>
                        <p>{{ $employer->email_additional }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Contact Number</strong></label>
                        <p>{{ $employer->phone }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mt-2">
                        <label><strong>Address</strong></label>
                        <p>{{ $employer->address }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>City</strong></label>
                        <p>{{ $employer->city }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>State</strong></label>
                        <p>{{ $employer->state }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Country</strong></label>
                        <p>{{ $employer->country }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Zipcode</strong></label>
                        <p>{{ $employer->zipcode }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Website</strong></label>
                        <p>{{ $employer->website }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group mt-2">
                        <label><strong>Description</strong></label>
                        <p>{{ $employer->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
