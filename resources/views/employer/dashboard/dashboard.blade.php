@extends('layouts.employer')
@section('title', 'Employer Dashboard')
@section('content')
<h5 class="page-title">Dashboard</h5>
<div class="row mt-2">
    <div class="col-6 ccard">
        <a href="{{ route('open-jobs') }}">
        <div class="card-body">
            <h5 class="text-center">Open Jobs</h5>
            <p class="text-center text-success">{{ $open }}</p>
        </div>
        </a>
    </div>
    <div class="col-6 ccard">
        <a href="{{ route('closed-jobs') }}">
            <div class="card-body">
                <h5 class="text-center">Closed Jobs</h5>
                <p class="text-center text-danger">{{ $closed }}</p>
            </div>
        </a>
    </div>
</div>
    <div class="recent-job">
        <h5>Recent Posted Job list</h5>
    </div>



    @if( isset($jobs) )

        @foreach($jobs as $job)
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
            <a href="{{ route('edit-job', $job->id) }}" class="viewApplicant btn btn-outline-primary" >Edit</a>
            <p class="text-muted posted-on text-end"><small>Posted:
                    {{ $job->created_at->diffForHumans() }}</small></p>
        </div>
        @endforeach
        <div class="text-center">
            <a href="{{ route('open-jobs') }}" class="btn btn-primary">View More Jobs</a>
        </div>




    @else
    <div class="text-center">
        <p>No job found</p>
    </div>

    @endif




@endsection

@push('scripts')
<script>
    jQuery(document).ready(function($){
        $('body').delegate('.view_more','click',function(e){
            var long  = $(this).attr('long');
            var short = $(this).attr('short');
            var html  = long+`<a class="view_less" long="${long}" short="${short}">View less</a>`;
            $(this).parent().html(html);
        });
        $('body').delegate('.view_less','click',function(e){
            var long  = $(this).attr('long');
            var short = $(this).attr('short');
            var html  = short+`<a class="view_more" long="${long}" short="${short}">View more</a>`;
            $(this).parent().html(html);
        });
    });
    </script>
@endpush
