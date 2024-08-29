@extends('layouts.app')
@section('title', 'Employee Login')
@section('content')
<style>
    body{
        background: #f3f3f3;
    }
</style>
<div class="container">
    @if(isset($warning))
    <p class="text text-danger">{{ $warning }}</p>
    @endif
    <h5 class="login-title">Employee Login</h5>
    <div class="login-form">
        <form method="POST" action="{{ route('employee.login') }}">
            @csrf
            <div class="mb-2">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" autocomplete="email" autofocus>
                @error('email')
                    <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">

                <a href="{{ route('employee.password.request') }}" class="text-muted float-end"><small>Forgot
                        your password?</small></a>

                <label for="password" class="form-label">Password</label>
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
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                        class="form-check-input" id="checkbox-signin">
                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                </div>
            </div>
            <div class="d-grid mb-0 text-center">
                <button class="btn btn-primary btn-userlogin" type="submit"><i class="mdi mdi-login"></i>
                    Log In
                </button>
            </div>
        </form>
        <div class="form-group text-center mt-2">
            Don't have an account? <a
                href="{{ route('employee.register') }}"><strong>{{ __('Register') }}</strong></a>
        </div>
    </div>
</div>




















</div>
@endsection
