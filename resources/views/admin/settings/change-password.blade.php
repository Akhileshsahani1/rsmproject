@extends('layouts.admin')
@section('title', 'Change Password')
@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-dark">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-dark">Settings</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
                <h4 class="page-title">Change Password</h4>
            </div>
        </div>
    </div>
    @include('admin.includes.flash-message')
    <!-- end page title -->

</div> <!-- container -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="accountForm" method="POST" action="{{ route('admin.change-password') }}">
                    @csrf
                    <div class="form-group mb-2 {{ $errors->has('current_password') ? 'has-error' : '' }}">
                        <label for="current_password">Current password *</label>
                        <input type="password" id="current_password" name="current_password" class="form-control">
                        @error('current_password')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2 {{ $errors->has('new_password') ? 'has-error' : '' }}">
                        <label for="new_password">New password *</label>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                        @error('new_password')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2 {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                        <label for="new_password_confirmation">New password confirmation *</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-control">
                        @error('new_password_confirmation')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success" form="accountForm">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
