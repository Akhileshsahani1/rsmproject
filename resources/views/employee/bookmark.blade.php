@extends('layouts.employee')
@section('title', 'Bookmarks')
@section('content')
<h5 class="page-title">Bookmarks</h5>
    @forelse ($bookmarks as $bookmark)
                <div class="JobList">
                    <div class="box-content">
                        <span class="company-logo">
                            @if ($bookmark->job->employer->thumbnail)
                                <img src='{{ asset('storage/uploads/employer/' . $bookmark->job->employer->thumbnail . '') }}'
                                    alt="{{ $bookmark->job->employer->company_name }}" clas="card-img">
                            @else
                                <img src="{{ asset('assets/images/JobIMG.svg') }}" alt="Job Title" clas="card-img">
                            @endif
                        </span>
                        @if (Auth::guard('employee')->user())
                            @if (Helper::bookmarkExist($bookmark->job->id, Auth::guard('employee')->user()->id))
                                <a href="{{ route('employee.job.bookmark', $bookmark->job->id) }}"><img
                                        src="{{ asset('assets/images/icons/tag-active.png') }}" class="float-end"
                                        alt=""></a>
                            @else
                                <a href="{{ route('employee.job.bookmark', $bookmark->job->id) }}"><img
                                        src="{{ asset('assets/images/icons/tag.png') }}" class="float-end"
                                        alt=""></a>
                            @endif
                        @endif
                        <div class="location-group">
                            <h4 class="mb-0"><a href="{{ route('frontend.job.show', $bookmark->job->id) }}" class="text-dark">{{ $bookmark->job->position_name }}</a></h4>
                            <p>{{ $bookmark->job->employer->company_name }}</p>
                            <h6><i class="mdi mdi-map-marker"></i> {{ $bookmark->job->subzone->name }}, {{ $bookmark->job->area->name }} {{ $bookmark->job->region->name }}</h6>
                        </div>
                    </div>
                    <div class="openings mb-2 mt-2">
                        <span class="openingtotal me-3"><img src="{{ asset('assets/images/icons/users.svg') }}"
                                alt="Users"> Openings <b>{{ $bookmark->job->no_of_position }}</b></span>
                        <span class="salary"><img src="{{ asset('assets/images/icons/dollar.svg') }}"
                                alt="Users"> ${{ $bookmark->job->salary_from }} -
                            ${{ $bookmark->job->salary_upto }} per
                            month</span>
                    </div>
                    <div class="text-muted job-description">
                        {!! Str::limit($bookmark->job->description, 196, ' ...') !!} <a class="view_more" long="{!! $bookmark->job->description !!}"
                            short="{!! Str::limit($bookmark->job->description, 196, ' ...') !!}">View
                            more</a>
                    </div>
                    <p class="text-muted posted-on text-end"><small>Posted:
                            {{ $bookmark->job->created_at->diffForHumans() }}</small></p>

                </div>
            @empty
                <p class="text-center py-5">
                    No Bookmark found.
                </p>
            @endforelse
@endsection
