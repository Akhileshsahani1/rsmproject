@extends('layouts.admin')
@section('title', 'Company Details')
@section('head')
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">                        
                        <button type="submit" class="btn btn-sm btn-success" form="companyDetailForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Company Details</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

    </div> <!-- container -->

    <div class="row">
        <div class="col-12">
            <form id="companyDetailForm" method="POST" action="{{ route('admin.company-details') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">                            
                            <div class="col-sm-6 mb-2 {{ $errors->has('company') ? 'has-error' : '' }}">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="company" name="company"
                                    placeholder="Enter Company Name" value="{{ old('company', $company->company) }}">
                                @error('company')
                                    <span id="company-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>                            
                            <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email Address" value="{{ old('email', $company->email) }}">
                                @error('email')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>                            

                            <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Phone Number" value="{{ old('phone', $company->phone) }}">
                                @error('phone')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                <input id="dial-code" name="dialcode" type="hidden"
                                    value="{{ isset($company) ? $company->dialcode : '' }}">
                            </div>

                            <div class="col-sm-6 mb-2 {{ $errors->has('website') ? 'has-error' : '' }}">
                                <label for="website">Website URL</label>
                                <input type="text" class="form-control" id="website" name="website"
                                    placeholder="Enter Website URL" value="{{ old('website', $company->website) }}">
                                @error('website')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-sm-6 mb-2 {{ $errors->has('address_line_1') ? 'has-error' : '' }}">
                                <label for="address_line_1">Address Line 1</label>
                                <input type="text" class="form-control" id="address_line_1" name="address_line_1"
                                    placeholder="Enter Address Line 1" value="{{ old('address_line_1', $company->address_line_1) }}">
                                @error('address_line_1')
                                    <span id="address_line_1-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                <label for="address_line_2">Address Line 2</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2"
                                    placeholder="Enter Address Line 2" value="{{ old('address_line_2', $company->address_line_2) }}">
                                @error('address_line_2')
                                    <span id="address_line_2-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    placeholder="Enter City" value="{{ old('city', $company->city) }}">
                                @error('city')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state"
                                    placeholder="Enter State" value="{{ old('state', $company->state) }}">
                                @error('state')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label for="country">{{ __('Country') }}</label>

                                <select id="country" class="form-select" name="country">
                                    <option value="">Select Country</option>
                                </select>

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                                <label for="zipcode">Zipcode</label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode"
                                    placeholder="Enter Zipcode" value="{{ old('zipcode', $company->zipcode) }}">
                                @error('zipcode')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>                           
                            <div class="col-sm-6 mb-2 {{ $errors->has('facebook_link') ? 'has-error' : '' }}">
                                <label for="facebook_link">Facebook Link</label>
                                <input type="text" class="form-control" id="facebook_link" name="facebook_link"
                                    placeholder="Enter Facebook Page Link" value="{{ old('facebook_link', $company->facebook_link) }}">
                                @error('facebook_link')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('twitter_link') ? 'has-error' : '' }}">
                                <label for="twitter_link">Twitter Link</label>
                                <input type="text" class="form-control" id="twitter_link" name="twitter_link"
                                    placeholder="Enter Twitter Profile  Link" value="{{ old('twitter_link', $company->twitter_link) }}">
                                @error('twitter_link')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('instagram_link') ? 'has-error' : '' }}">
                                <label for="instagram_link">Instagram Link</label>
                                <input type="text" class="form-control" id="instagram_link" name="instagram_link"
                                    placeholder="Enter Instagram Page Link" value="{{ old('instagram_link', $company->instagram_link) }}">
                                @error('instagram_link')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('linkedin_link') ? 'has-error' : '' }}">
                                <label for="linkedin_link">LinkedIn Link</label>
                                <input type="text" class="form-control" id="linkedin_link" name="linkedin_link"
                                    placeholder="Enter Linked In Profile Link" value="{{ old('linkedin_link', $company->linkedin_link) }}">
                                @error('linkedin_link')
                                    <span id="linkedin_link-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('google_play_link') ? 'has-error' : '' }}">
                                <label for="google_play_link">Google Playstore App Link</label>
                                <input type="text" class="form-control" id="google_play_link" name="google_play_link"
                                    placeholder="Enter Google Playstore App Link" value="{{ old('google_play_link', $company->google_play_link) }}">
                                @error('google_play_link')
                                    <span id="google_play_link-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('apple_store_link') ? 'has-error' : '' }}">
                                <label for="apple_store_link">Apple Store App Link</label>
                                <input type="text" class="form-control" id="apple_store_link" name="apple_store_link"
                                    placeholder="Enter Apple Store App Link" value="{{ old('apple_store_link', $company->apple_store_link) }}">
                                @error('apple_store_link')
                                    <span id="apple_store_link-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Enter Company Description" rows="3">{{ old('description', $company->description) }}</textarea>
                                @error('description')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="logo">Logo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="logo" name="logo"
                                        onchange="loadPreview(this);">
                                </div>
                                @if ($errors->has('logo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                                <img id="preview_img" src="{{ $company->logo }}" class="mt-2"
                                    width="217" height="40" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">                        
                        <button type="submit" class="btn btn-sm btn-success" form="companyDetailForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                </div>                
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(217)
                        .height(40);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

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
            initialCountry: "{{ old('country', $company->iso2) }}",
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
