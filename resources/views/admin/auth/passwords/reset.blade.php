<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Reset Password | Administrator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Cloudinc" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="favicon.png">

        <!-- App css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="light-style" />        
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />       
    </head>

    <body>
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header py-2 bg-dark text-center">
                                <a href="{{ route('admin.login') }}">
                                    <span><img src="{{ Helper::getLogo() }}"></span>                                 
                                </a>
                            </div>

                            <div class="card-body">

                                <div class="text-center w-75 m-auto">
                                    <h3 class="text-dark-50 text-center mt-0 mb-3 font-weight-bold">Reset Password</h3>
                                </div>

                                <form action="{{ route('admin.password.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="mb-2">
                                        <label for="emailaddress" class="form-label">Email address</label>
                                        <input class="form-control" type="email" name="email" id="emailaddress" value="{{ $email ?? old('email') }}">
                                        @error('email')
                                            <code id="email-error" class="text-danger">{{ $message }}</code>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
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
                                            <code id="password-error" class="text-danger">{{ $message }}</code>
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
                                    </div>

                                    <div class="d-grid mb-0 text-center">
                                        <button class="btn btn-dark" type="submit">Reset Password </button>
                                    </div>

                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <script>document.write(new Date().getFullYear())</script> © RSM
        </footer>

        <!-- bundle -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>

    </body>
</html>
