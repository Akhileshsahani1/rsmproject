@extends('layouts.employee')
@section('title', 'Change Password')
@section('content')
<h5 class="page-title">Change Password</h5>
    <div class="card">
        <div class="card-body">
            <form id="passwordForm" method="POST" action="{{ route('employee.change-password') }}">
                @csrf
                <div class="form-group mb-2 {{ $errors->has('current_password') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="current_password">Current password *</label>
                    <input type="password" id="current_password" name="current_password" class="form-control"
                        placeholder="Enter your current password">
                    @error('current_password')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-2 {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="new_password">New password *</label>
                    <input type="password" id="new_password" name="new_password" class="form-control"
                        placeholder="Enter your new password">
                    @error('new_password')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-2 {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="new_password_confirmation">Confirm Password *</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="form-control" placeholder="Confirm your new password">
                    @error('new_password_confirmation')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </form>

        </div>

        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" form="passwordForm">Update Password</button>
        </div>

    </div>
@endsection
