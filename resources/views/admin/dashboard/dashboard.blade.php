@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="javascript:void(0)" class="btn btn-sm btn-grey">
                            <i class="uil-clock me-1"></i> <span class="hms"></span><span class="ampm"></span>
                        </a>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @include('admin.includes.flash-message')

        <div class="row">

            <div class="col-sm-4">
                <div class="card border tilebox-one">
                    <div class="card-body">
                        <i class="mdi mdi-account-group float-end"></i>
                        <h5 class="mt-0">Total Employers</h5>
                        <h3 class="my-1" id="active-users-count">{{ \App\Models\User::count() }}</h3>
                        <p class="mb-0 text-muted text-end">
                            <span class="text-nowrap text-white">See Details</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border tilebox-one">
                    <div class="card-body">
                        <i class="mdi mdi-account-check float-end"></i>
                        <h5 class="mt-0">Approved Employers</h5>
                        <h3 class="my-1" id="active-users-count">{{ \App\Models\User::where('status', true)->count() }}</h3>
                        <p class="mb-0 text-muted text-end">
                            <span class="text-nowrap"><a href="{{ route('admin.employers.index', ['status' => true]) }}"><span class="text-muted">See Details</span></a></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border tilebox-one">
                    <div class="card-body">
                        <i class="mdi mdi-account-clock-outline float-end"></i>
                        <h5 class="mt-0">Pending Employers</h5>
                        <h3 class="my-1" id="active-users-count">{{ \App\Models\User::where('status', false)->count() }}</h3>
                        <p class="mb-0 text-muted text-end">
                            <span class="text-nowrap"><a href="{{ route('admin.employers.index', ['status' => false]) }}"><span class="text-muted">See Details</span></a></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-suitcase float-end"></i>
                        <h5 class="mt-0">Total Jobs</h5>
                        <h3 class="my-1" id="active-users-count">{{ \App\Models\Job::count() }}</h3>
                        <p class="mb-0 text-muted text-end">
                            <span class="text-nowrap text-white">See Details</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border tilebox-one">
                    <div class="card-body">
                        <i class="mdi mdi-checkbox-marked-outline float-end"></i>
                        <h5 class="mt-0">Approved Jobs</h5>
                        <h3 class="my-1" id="active-users-count">{{ \App\Models\Job::where('status', 'approved')->count() }}</h3>
                        <p class="mb-0 text-muted text-end">
                            <span class="text-nowrap"><a href="{{ route('admin.jobs.index', ['status' => 'approved']) }}"><span class="text-muted">See Details</span></a></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border tilebox-one">
                    <div class="card-body">
                        <i class="mdi mdi-clock-outline float-end"></i>
                        <h5 class="mt-0">Pending Jobs</h5>
                        <h3 class="my-1" id="active-users-count">{{ \App\Models\Job::where('status', 'pending')->count() }}</h3>
                        <p class="mb-0 text-muted text-end">
                            <span class="text-nowrap"><a href="{{ route('admin.jobs.index', ['status' => 'pending']) }}"><span class="text-muted">See Details</span></a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')    
@endpush
