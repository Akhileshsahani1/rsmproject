@extends('layouts.app')
@section('title', 'Employer Signup')
@section('head')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}">
@endsection
@section('content')
<style>
    body{
        background: #f3f3f3;
    }
</style>
<div class="container">
    <h5 class="login-title">Employer Signup</h5>
    <div class="login-form">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="company_name" class="col-form-label">{{ __('Company Name') }}</label>

                    <input id="company_name" type="text"
                        class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                        value="{{ old('company_name') }}" autocomplete="company_name" autofocus>

                    @error('company_name')
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
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
            <div class="form-group text-center mt-2">
                Already have an account? <a
                    href="{{ route('login') }}"><strong>{{ __('Login') }}</strong></a>
            </div>
        </form>
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
