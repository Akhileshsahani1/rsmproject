@extends('layouts.employer')
@section('title', 'Open Jobs')
@section('content')
<h5 class="page-title">Open Jobs</h5>
    @forelse($jobs as $job)
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
                    alt="Users"> ${{ $job->salary_from }} - ${{ $job->salary_upto }} /
                Month</span>
        </div>
        <div class="text-muted job-description">
            {!! Str::limit($job->description, 196, ' ...') !!} @if(Str::length($job->description) > 196 )<a class="view_more"
                long="{!! $job->description !!}" short="{!! Str::limit($job->description, 196, ' ...') !!}">View
                more</a>
                @endif
        </div>
        <a href="{{ route('edit-job', $job->id) }}" class="viewApplicant btn btn-outline-primary" style="right:180px;">Edit</a>
        <a href="{{ route('job.applicants', $job->id) }}" class="viewApplicant btn btn-outline-primary">View Applicants</a>

        <p class="text-muted posted-on text-end"><small>Posted:
                {{ $job->created_at->diffForHumans() }}</small></p>
    </div>
    @empty
    <p class="text-center py-5">
        No Open Jobs found.
    </p>
    @endforelse
@endsection
