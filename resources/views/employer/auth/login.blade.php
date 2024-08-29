@extends('layouts.app')
@section('title', 'Employeer | Login')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
            <!--<ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link float-end rounded-0">
                        <img src="{{ asset('assets/images/teacher.png') }}" width="25%">
                        <br>
                        <p class="mt-1 mb-0">Login as Employer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employee.login') }}" class="nav-link float-end rounded-0 active">
                        <img src="{{ asset('assets/images/student.png') }}" width="25%">
                        <br>
                        <p class="mt-1  mb-0">Login as Employee</p>
                    </a>
                </li>

            </ul>-->

            <div class="tab-content">
                <div class="tab-pane show active" id="tutor-login">
                    <div class="row">
                        <div class="col-md-12">
                           <div class="card">
                                <div class="card-header bg-dark text-white text-center">
                                    <h5 class="card-title mb-0">Employee Login</h5>
                                </div>
                                <div class="card-body">
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
                                            <button class="btn btn-warning btn-userlogin" type="submit"><i class="mdi mdi-login"></i>
                                                Log In
                                            </button>
                                        </div>


                                    </form>
                                    <div class="form-group text-center mt-2">
                                        Don't have an account? <a
                                            href="{{ route('employee.register') }}">{{ __('Register') }}</a>
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
