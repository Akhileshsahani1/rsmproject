@extends('layouts.employer')
@section('title', 'Bookmarks')
@section('content')
<h5 class="page-title">Bookmarks</h5>
@forelse ($bookmarks as $bookmark)
    <div class="JobList">
        <div class="box-content">
            <span class="company-logo">
                @if ($bookmark->employee->avatar)
                    <img src='{{ asset('storage/uploads/employees/' . $bookmark->employee->slug . '/avatar' . '/' . $bookmark->employee->avatar) }}'
                        alt="{{ $bookmark->employee->firstname . ' ' . $bookmark->employee->lastname }}"
                        clas="card-img">
                @else
                    <img src="{{ asset('assets/images/applicant-placeholder.svg') }}" alt="Job Title" clas="card-img">
                @endif
            </span>
            @if (Helper::employeeBookmarkExist($bookmark->employee->id, Auth::user()->id))
                <a href="{{ route('employee.bookmark', $bookmark->employee->id) }}"><img
                        src="{{ asset('assets/images/icons/tag-active.png') }}" class="float-end"
                        alt=""></a>
            @else
                <a href="{{ route('employee.bookmark', $bookmark->employee->id) }}"><img
                        src="{{ asset('assets/images/icons/tag.png') }}" class="float-end"
                        alt=""></a>
            @endif
            <h4 class="mb-0"><a href="{{ route('view.applicant.bookmark', $bookmark->employee->id) }}"
                    class="text-dark">{{ $bookmark->employee->firstname }}
                    {{ $bookmark->employee->lastname }}</a></h4>
            <p class="text-muted"><span
                    class="companyname">{{ $bookmark->employee->preferredclassification->classification }}
                    <i class="mdi mdi-arrow-right"> </i><span
                        class="companyname">{{ $bookmark->employee->preferredsubclassification->sub_classification }}</span>
            </p>
        </div>
        <div class="eployee-contact">
            <div class="app-openingtotal"><i class="mdi mdi-email"></i> <span>{{ $bookmark->employee->email }}</span></div>
            <div class="app-openingtotal"><i class="mdi mdi-phone"></i> <span>{{ $bookmark->employee->phone }}</span></div>
            <div class="app-openingtotal"><i class="uil-graduation-hat"> </i><span>{{ $bookmark->employee->highest_education }}</span></div>
        </div>
        <div class="skill-badge">
            @foreach ($bookmark->employee->job_skill as $skill)
                <span class="badge badge-outline badge-pill">{{ $skill }}</span>
            @endforeach
        </div>
        <div class="text-muted job-description">
            {{ $bookmark->employee->description }}
        </div>
        <p class="text-muted posted-on text-end"><small>Bookmarked: {{ $bookmark->created_at->diffForHumans() }}</small></p>
    </div>
    @empty
        <p class="text-center py-5">
            No Bookmark found.
        </p>
    @endforelse
@endsection
