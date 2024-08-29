@extends('layouts.app')
@section('title', 'Approval Pending')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <!-- Logo -->

                    <div class="card-header py-2 bg-blue text-center">
                        <a href="{{ route('login') }}">
                            <span><img src="{{ Helper::getLogo() }}"></span>
                        </a>
                    </div>

                    <div class="card-body">

                        <div class="alert bg-warning text-center" role="alert">
                            <h4><i class="dripicons-warning me-1"></i> Approval Pending</h4>
                        </div>

                        <div class="text-center w-100 m-auto mt-2">
                            <h4>Your account is under review for approval by Administartor.</h4>
                            <h5 class="text-muted">The approval process usually takes 12-24 hours to complete.</h5>
                            <h5 class="text-muted">Once approved, you will be notified via email!</h5>
                            <p>Thank You!</p>
                        </div>
                        <div class="text-center w-100 m-auto mt-4">
                            <p class="text-muted">Back to <a href="{{ route('employee.login') }}" class="text-dark ml-1"><b>Log
                                        In</b></a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
