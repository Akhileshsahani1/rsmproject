@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <div class="tab-content">
                    <div class="tab-pane show active" id="employer-reset">
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
                                            <div class="mb-2">                                               
                                                <label for="password" class="form-label">New Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password" name="password" class="form-control">
                                                    <div class="input-group-append" data-password="false">
                                                        <div class="input-group-text">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <span id="password-error" class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2">                                               
                                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                                    <div class="input-group-append" data-password="false">
                                                        <div class="input-group-text">
                                                            <span class="password-eye"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('password_confirmation')
                                                    <span id="password_confirmation-error" class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="d-grid mb-0 text-center">
                                                <button class="btn btn-warning btn-userlogin" type="submit"><i
                                                        class="mdi mdi-key me-1"></i>
                                                        {{ __('Reset Password') }}
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
