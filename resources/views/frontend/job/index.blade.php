@extends('layouts.app')
@section('title', 'All Jobs')
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
                                        placeholder="Enter job title, position, skills…" name="position_name" value="{{ $name }}">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><img src="{{ asset('assets/images/icons/location.svg') }}"
                                            alt="search"></span>
                                    <input type="text" class="form-control inputstylesearch" placeholder="Location"
                                        name="address" value="{{ $address }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="joblistpage">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-12">
                <button type="button" class="btn btn-success block hidden-lg" id="ShowFilter">Show Filter </button>
                <button type="button" class="btn btn-danger block hidden-lg" id="HideFilter" style="display: none">Hide Filter</button>
                    @include('frontend.job.filter')
                </div>
                <div class="col-sm-9 col-12">
                    @forelse ($jobs as $job)
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
                                <span class="openingtotal me-3"><img
                                        src="{{ asset('assets/images/icons/users.svg') }}" alt="Users">
                                    Openings <b>{{ $job->no_of_position }}</b></span>
                                <span class="salary"><img src="{{ asset('assets/images/icons/dollar.svg') }}"
                                        alt="Users"> ${{ $job->salary_from }} - ${{ $job->salary_upto }} / Month</span>
                            </div>
                            <div class="text-muted job-description">
                                {!! Str::limit($job->description, 196, ' ...') !!} @if(Str::length($job->description) > 196 ) <a class="view_more" long="{!! $job->description !!}"
                                    short="{!! Str::limit($job->description, 196, ' ...') !!}">View
                                    more</a>
                                @endif
                            </div>
                            <p class="text-muted posted-on text-end"><small>Posted: {{ $job->created_at->diffForHumans() }}</small></p>
                        </div>
                    @empty
                        <div class="text-center">
                            <p>No Job Found for the matching search criterion.</p>
                        </div>
                    @endforelse

                    <div class="mt-1">
                        {{ $jobs->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
    function getFilterData(){
       $('#form-filter').submit();
    }
</script>
<script>
    jQuery(document).ready(function($) {

        $('body').delegate('.view_more', 'click', function(e) {
            var long = $(this).attr('long');
            var short = $(this).attr('short');
            var html = long + `<a class="view_less" long="`+long+`" short="`+short+`">View
                            less</a>`;
            $(this).parent().html(html)
        });

        $('body').delegate('.view_less', 'click', function(e) {
            var long = $(this).attr('long');
            var short = $(this).attr('short');
            var html = short + `<a class="view_more" long="`+long+`" short="`+short+`">View
                            more</a>`;
            $(this).parent().html(html)
        });


    });

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
