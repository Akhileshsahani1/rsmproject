@extends('layouts.admin')
@section('title', 'Approve Employer')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('admin.employers.index') }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                    </div>
                    <h4 class="page-title">Approve Employer</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

    </div> <!-- container -->

    <div class="row">       
        <div class="col-md-5 mx-auto">
            <div class="d-grid mb-3">
                <a class="btn btn-warning" href="javascript:void(0);" onclick="approveEmployer()"><i class="fa fa-check me-1"></i> Approve Employer</a>
                <form action="{{ route('admin.employers.approve', $employer->id) }}" id="approval-form" method="POST">
                    @csrf
                    @method('PUT')          
                    </form>
            </div>
            <div class="card bg-dark">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="{{ $employer->avatar }}" alt=""
                                            class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="text-white">#{{ $employer->id }} {{ $employer->firstname }}
                                            {{ $employer->lastname }}</h4>
                                        <span class="font-13 text-white-50"><i class="mdi mdi-account-outline me-1"></i>
                                           Employer</span><br>
                                        <span class="font-13 text-white-50"><i class="mdi mdi-email-outline me-1"></i>
                                            {{ $employer->email }}</span><br>
                                        <span class="font-13 text-white-50"><i class="mdi mdi-phone me-1"></i>
                                            {{ $employer->phone }}</span><br>
                                        @isset($employer->gender)
                                            @if ($employer->gender == 'Male')
                                                <span class="font-13 text-white-50"><i class="mdi mdi-gender-male me-1"></i>
                                                    {{ $employer->gender }}</span><br>
                                            @else
                                                <span class="font-13 text-white-50"><i class="mdi mdi-gender-female me-1"></i>
                                                    {{ $employer->gender }}</span><br>
                                            @endif
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-grid mb-2">
                <a class="btn btn-secondary" href="{{ route('admin.employers.show', $employer->id) }}"><i class="fa fa-eye me-1"></i> More Details</a>
            </div>
            <div class="d-grid mb-2">
                <a class="btn btn-info" href="{{ route('admin.employers.edit', $employer->id) }}"><i class="fa fa-edit me-1"></i> Edit Employer</a>
            </div>
            <div class="d-grid mb-2">
                <a href="javascript:void(0);" onclick="confirmDelete({{ $employer->id }})" class="btn btn-danger"><i class="fa fa-trash-alt me-1"></i> Delete Employer</a>
                    <form id='delete-form{{ $employer->id }}'
                        action='{{ route('admin.employers.destroy', $employer->id) }}'
                        method='POST'>
                        <input type='hidden' name='_token'
                            value='{{ csrf_token() }}'>
                        <input type='hidden' name='_method' value='DELETE'>
                    </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && document.getElementById("delete-form" + e).submit()
            })
        }
    </script>
    <script>
        function approveEmployer() {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to approve this employer!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Approve Employer!"
            }).then(t => {
                t.isConfirmed && document.getElementById("approval-form").submit()
            })
        }
    </script>
@endpush
