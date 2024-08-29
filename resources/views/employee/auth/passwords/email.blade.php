@extends('layouts.app')
@section('title', 'Employee Reset Password')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <div class="tab-content">
                    <div class="tab-pane show active" id="employee-reset">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-dark text-white text-center">
                                        <h5 class="card-title mb-0">{{ __('Employee Reset Password') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('employee.password.email') }}">
                                            @csrf
                                            <div class="mb-2">
                                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" autocomplete="email" autofocus>
                                                @error('email')
                                                    <span id="email-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="d-grid mb-0 text-center">
                                                <button class="btn btn-warning btn-userlogin" type="submit"><i
                                                        class="mdi mdi-send me-1"></i>
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </form>
                                        <div class="form-group text-center mt-2">
                                            Back to <a href="{{ route('employee.login') }}">{{ __('Login') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
