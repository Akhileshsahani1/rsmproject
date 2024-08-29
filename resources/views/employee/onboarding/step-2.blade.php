@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <div class="card">

                    <!-- Logo -->

                    <div class="row">
                        <div class="col-6">
                            <div class="card-header bg-blue text-white text-center">
                                <h5 class="card-title  mb-0">Onboarding</h5>
                                <p class="mb-0">Step-1</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-header bg-skin text-white text-center">
                                <h5 class="card-title  mb-0">Onboarding</h5>
                                <p class="mb-0">Step-2</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center w-85 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold"></h4>
                            <p class="text-muted mb-2">Enter the following details to complete your profile.</p>
                        </div>
                        <form action="{{ route('employee.onboarding.stepTwo') }}" method="POST"
                            enctype="multipart/form-data" id="profileForm">
                            @csrf
                            <div class="row">
                                
                                <div class="col-sm-12 mb-1 {{ $errors->has('experience') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="experience">Recent experience</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="experience" name="experience"
                                            onchange="showExperienceDiv()" {{ $employee->have_experience ? "checked" : "" }}>
                                        <label class="form-check-label" for="experience">I have experience</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="experience_div">
                                <div class="col-sm-12 mb-1 {{ $errors->has('job_title') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="job_title">Job Title</label>
                                    <input type="text" class="form-control" id="job_title" name="job_title"
                                        placeholder="Enter Job Title" value="{{ old('job_title', $employee->job_title) }}">
                                    @error('job_title')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-1 {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="company">Company Name</label>
                                    <input type="text" class="form-control" id="company" name="company"
                                        placeholder="Enter Company Name" value="{{ old('company', $employee->company) }}">
                                    @error('company')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 {{ $errors->has('started') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="started">Started</label>
                                </div>
                                <div class="col-sm-6">
                                    <select id="month_started" class="form-select" name="month_started">
                                        <option value="">Month</option>
                                        <option value="January"
                                            {{ old('month_started', $employee->month_started) == 'January' ? 'selected' : '' }}>
                                            January
                                        </option>
                                        <option value="February"
                                            {{ old('month_started', $employee->month_started) == 'February' ? 'selected' : '' }}>
                                            February
                                        </option>
                                        <option value="March"
                                            {{ old('month_started', $employee->month_started) == 'March' ? 'selected' : '' }}>
                                            March
                                        </option>
                                        <option value="April"
                                            {{ old('month_started', $employee->month_started) == 'April' ? 'selected' : '' }}>
                                            April
                                        </option>
                                        <option value="May"
                                            {{ old('month_started', $employee->month_started) == 'May' ? 'selected' : '' }}>
                                            May
                                        </option>
                                        <option value="June"
                                            {{ old('month_started', $employee->month_started) == 'June' ? 'selected' : '' }}>
                                            June
                                        </option>
                                        <option value="July"
                                            {{ old('month_started', $employee->month_started) == 'July' ? 'selected' : '' }}>
                                            July
                                        </option>
                                        <option value="August"
                                            {{ old('month_started', $employee->month_started) == 'August' ? 'selected' : '' }}>
                                            August
                                        </option>
                                        <option value="September"
                                            {{ old('month_started', $employee->month_started) == 'September' ? 'selected' : '' }}>
                                            September
                                        </option>
                                        <option value="October"
                                            {{ old('month_started', $employee->month_started) == 'October' ? 'selected' : '' }}>
                                            October
                                        </option>
                                        <option value="November"
                                            {{ old('month_started', $employee->month_started) == 'November' ? 'selected' : '' }}>
                                            November
                                        </option>
                                        <option value="December"
                                            {{ old('month_started', $employee->month_started) == 'December' ? 'selected' : '' }}>
                                            December
                                        </option>
                                    </select>
                                    @error('month_started')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <select id="year_started" class="form-select" name="year_started">
                                        <option value="">Year</option>
                                        @php
                                            $end_year = \Carbon\Carbon::now()->format('Y');
                                            $start_year = $end_year - 100;
                                        @endphp
                                        @for ($i = $start_year; $i <= $end_year; $i++)
                                            <option value="{{ $i }}" {{ $employee->year_started == $i ? "selected" : "" }}>{{ $i }}</option>
                                        @endfor

                                    </select>
                                    @error('year_started')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 {{ $errors->has('ended') ? 'has-error' : '' }}">
                                    <div class="form-check mt-2 float-end">
                                        <input type="checkbox" class="form-check-input" id="still_in_role" name="still_in_role" onchange="showStillInRoleDiv()"  {{ $employee->still_in_role ? "checked" : "" }}>
                                        <label class="form-check-label" for="still_in_role">Still in Role</label>
                                    </div>
                                    <label class="col-form-label" for="ended">Ended</label>
                                </div>

                                <div class="col-sm-6 ended_div">
                                    <select id="month_ended" class="form-select" name="month_ended">
                                        <option value="">Month</option>
                                        <option value="January"
                                            {{ old('month_ended', $employee->month_ended) == 'January' ? 'selected' : '' }}>
                                            January
                                        </option>
                                        <option value="February"
                                            {{ old('month_ended', $employee->month_ended) == 'February' ? 'selected' : '' }}>
                                            February
                                        </option>
                                        <option value="March"
                                            {{ old('month_ended', $employee->month_ended) == 'March' ? 'selected' : '' }}>
                                            March
                                        </option>
                                        <option value="April"
                                            {{ old('month_ended', $employee->month_ended) == 'April' ? 'selected' : '' }}>
                                            April
                                        </option>
                                        <option value="May"
                                            {{ old('month_ended', $employee->month_ended) == 'May' ? 'selected' : '' }}>May
                                        </option>
                                        <option value="June"
                                            {{ old('month_ended', $employee->month_ended) == 'June' ? 'selected' : '' }}>
                                            June
                                        </option>
                                        <option value="July"
                                            {{ old('month_ended', $employee->month_ended) == 'July' ? 'selected' : '' }}>
                                            July
                                        </option>
                                        <option value="August"
                                            {{ old('month_ended', $employee->month_ended) == 'August' ? 'selected' : '' }}>
                                            August
                                        </option>
                                        <option value="September"
                                            {{ old('month_ended', $employee->month_ended) == 'September' ? 'selected' : '' }}>
                                            September
                                        </option>
                                        <option value="October"
                                            {{ old('month_ended', $employee->month_ended) == 'October' ? 'selected' : '' }}>
                                            October
                                        </option>
                                        <option value="November"
                                            {{ old('month_ended', $employee->month_ended) == 'November' ? 'selected' : '' }}>
                                            November
                                        </option>
                                        <option value="December"
                                            {{ old('month_ended', $employee->month_ended) == 'December' ? 'selected' : '' }}>
                                            December
                                        </option>
                                    </select>
                                    @error('month_ended')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6 ended_div">
                                    <select id="year_ended" class="form-select" name="year_ended">
                                        <option value="">Year</option>
                                        @php
                                            $end_year = \Carbon\Carbon::now()->format('Y');
                                            $start_year = $end_year - 100;
                                        @endphp
                                        @for ($i = $start_year; $i <= $end_year; $i++)
                                            <option value="{{ $i }}" {{ $employee->year_ended == $i ? "selected" : "" }}>{{ $i }}</option>
                                        @endfor

                                    </select>
                                    @error('year_ended')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 my-2">
                                    <section class="p-2" style="background-color: #EBE6EE">
                                        <h3>Be found by employers</h3>
                                        <p>Your profile visibility setting controls if you can be approached by employers
                                            and recruiters with job opportunities.</p>
                                        <select id="profile_visibility" class="form-select mb-2" name="profile_visibility">
                                            <option value="">Select Visibility</option>
                                            <option value="Standard"
                                                {{ old('profile_visibility', $employee->profile_visibility) == 'Standard' ? 'selected' : '' }}>
                                                Standard (Recommended)
                                            </option>
                                            <option value="Limited"
                                                {{ old('profile_visibility', $employee->profile_visibility) == 'Limited' ? 'selected' : '' }}>
                                                Limited
                                            </option>
                                            <option value="Hidden"
                                                {{ old('profile_visibility', $employee->profile_visibility) == 'Hidden' ? 'selected' : '' }}>
                                                Hidden
                                            </option>
                                        </select>
                                        @error('profile_visibility')
                                    <span id="profile_visibility-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                        <p>For all settings, your Profile including any verified credentials will be sent to
                                            the employer with your applications.<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#full-width-modal"> Learn more about
                                                visibility</a></p>
                                    </section>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('employee.onboarding.stepOne') }}" class="btn btn-sm btn-warning me-1">Back</a>
                        <button type="submit" class="btn btn-sm btn-success" form="profileForm">Save</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('employee.onboarding.profile-policy')
@endsection
@push('scripts')
   
    <script>
        function showExperienceDiv() {
            if ($("#experience").is(':checked')) {
                $("#experience_div").show();
            } else {
                $("#experience_div").hide();
            }
        }
    </script>
    <script>
        function showStillInRoleDiv() {
            if ($("#still_in_role").is(':checked')) {
                $(".ended_div").hide();
            } else {
                $(".ended_div").show();
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            showExperienceDiv();
            showStillInRoleDiv();
        });
    </script>
    
@endpush
