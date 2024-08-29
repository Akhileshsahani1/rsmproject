@extends('layouts.admin')
@section('title', 'Approve Employee')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('admin.employees.index') }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                    </div>
                    <h4 class="page-title">Approve Employee</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

    </div> <!-- container -->

    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="d-grid mb-3">
                <a class="btn btn-warning" href="javascript:void(0);" onclick="approveEmployee()"><i class="fa fa-check me-1"></i> Approve Employee</a>
                <form action="{{ route('admin.employees.approve', $employee->id) }}" id="approval-form" method="POST">
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
                                        <img src="{{ $employee->avatar }}" alt=""
                                            class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="text-white">#{{ $employee->id }} {{ $employee->firstname }}
                                            {{ $employee->lastname }}</h4>
                                        <span class="font-13 text-white-50"><i class="mdi mdi-account-outline me-1"></i>
                                           employees</span><br>
                                        <span class="font-13 text-white-50"><i class="mdi mdi-email-outline me-1"></i>
                                            {{ $employee->email }}</span><br>
                                        <span class="font-13 text-white-50"><i class="mdi mdi-phone me-1"></i>
                                            {{ $employee->phone }}</span><br>
                                        @isset($employee->gender)
                                            @if ($employee->gender == 'Male')
                                                <span class="font-13 text-white-50"><i class="mdi mdi-gender-male me-1"></i>
                                                    {{ $employee->gender }}</span><br>
                                            @else
                                                <span class="font-13 text-white-50"><i class="mdi mdi-gender-female me-1"></i>
                                                    {{ $employee->gender }}</span><br>
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
                <a class="btn btn-secondary" href="{{ route('admin.employees.show', $employee->id) }}"><i class="fa fa-eye me-1"></i> More Details</a>
            </div>
            <div class="d-grid mb-2">
                <a class="btn btn-info" href="{{ route('admin.employees.edit', $employee->id) }}"><i class="fa fa-edit me-1"></i> Edit employees</a>
            </div>
            <div class="d-grid mb-2">
                <a href="javascript:void(0);" onclick="confirmDelete({{ $employee->id }})" class="btn btn-danger"><i class="fa fa-trash-alt me-1"></i> Delete employees</a>
                    <form id='delete-form{{ $employee->id }}'
                        action='{{ route('admin.employees.destroy', $employee->id) }}'
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
        function approveEmployee() {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to approve this employee!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Approve Employee!"
            }).then(t => {
                t.isConfirmed && document.getElementById("approval-form").submit()
            })
        }
    </script>
@endpush
