@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 mb-3">
        <div class="col-lg-6">
            <!--<ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link float-end rounded-0 ">
                        <img src="{{ asset('assets/images/teacher.png') }}" width="25%">
                        <br>
                        <p class="mt-1 mb-0">Signup as Employer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employee.register') }}" class="nav-link float-end rounded-0 active">
                        <img src="{{ asset('assets/images/student.png') }}" width="25%">
                        <br>
                        <p class="mt-1  mb-0">Signup as Employee</p>
                    </a>
                </li>

            </ul>-->

            <div class="tab-content">
                <div class="tab-pane show active" id="tutor-signup">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-dark text-white text-center">
                                    <h5 class="card-title mb-0">Employee Signup</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('employee.register') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="firstname" class="col-form-label">{{ __('Firstname') }}</label>
    
                                                <input id="firstname" type="text"
                                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                                    value="{{ old('firstname') }}" autocomplete="firstname" autofocus>
    
                                                @error('firstname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
    
                                            <div class="form-group col-md-6">
                                                <label for="lastname" class="col-form-label">{{ __('Lastname') }}</label>
    
                                                <input id="lastname" type="text"
                                                    class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                                    value="{{ old('lastname') }}" autocomplete="lastname" autofocus>
    
                                                @error('lastname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="email"
                                                class="col-form-label">{{ __('Email Address') }}</label>

                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="phone"
                                                class="col-form-label">{{ __('Phone Number') }}</label>

                                            <input id="phone" type="tel" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" autocomplete="phone">
                                            <input id="dial-code" name="dialcode" type="hidden"></select>

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group" style="display: none">
                                            <label for="country" class="col-form-label">{{ __('Country') }}</label>

                                            <select id="country"
                                                class="form-control @error('country') is-invalid @enderror"
                                                name="country">
                                                <option value="">Select Country</option>
                                            </select>

                                            @error('country')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">                                               
                                            <label for="password" class="col-form-label">New Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="password" class="form-control">
                                                <div class="input-group-append" data-password="false">
                                                    <div class="input-group-text">
                                                        <span class="password-eye"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">                                               
                                            <label for="password_confirmation" class="col-form-label">Confirm Password</label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                                <div class="input-group-append" data-password="false">
                                                    <div class="input-group-text">
                                                        <span class="password-eye"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>                                        

                                        <div class="form-group text-center mt-3">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-warning">
                                                    {{ __('Register') }}
                                                </button>
                                            </div>


                                        </div>

                                        <div class="form-group text-center mt-2">
                                            Already have an account? <a
                                                href="{{ route('employee.login') }}">{{ __('Login') }}</a>
                                        </div>

                                    </form>
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
@push('scripts')
    <script src="{{ asset('assets/js/plugins/intl-tel-input/js/intlTelInput.min.js') }}"></script>
    <script>
        // get the country data from the plugin
        var countryData = window.intlTelInputGlobals.getCountryData(),

            input = document.querySelector("#phone"),
            dialCode = document.querySelector("#dial-code");
        countryDropdown = document.querySelector("#country");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            countryDropdown.appendChild(optionNode);
        }

        // init plugin
        var iti = window.intlTelInput(input, {
            initialCountry: "{{ old('country', 'SG') }}",
            utilsScript: "{{ asset('assets/js/plugins/intl-tel-input/js/utils.js') }}" // just for formatting/placeholders etc
        });

        // set it's initial value
        dialCode.value = '+' + iti.getSelectedCountryData().dialCode;
        countryDropdown.value = iti.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        input.addEventListener('countrychange', function(e) {
            dialCode.value = '+' + iti.getSelectedCountryData().dialCode;
            countryDropdown.value = iti.getSelectedCountryData().iso2;
        });

        // listen to the address dropdown for changes
        countryDropdown.addEventListener('change', function() {
            iti.setCountry(this.value);
        });
    </script>
@endpush
