@extends('layouts.admin')
@section('title', 'Edit Employer')
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
                        <a href="{{ route('admin.employers.index', ['status' => $employer->status]) }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-success" form="employerForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Employer</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

    </div> <!-- container -->

    <div class="row">
        <div class="col-12">
            <form id="employerForm" method="POST" action="{{ route('admin.employers.update', $employer->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <h4 class="text-dark">Personal Details</h4>
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('owner_name') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="owner_name">Owner Name <span class="text text-danger">*</span></label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name"
                                    placeholder="Enter Owner Name" value="{{ old('owner_name', $employer->owner_name) }}">
                                @error('owner_name')
                                    <span id="owner_name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="email">Email Address <span class="text text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email Address" value="{{ old('email', $employer->email) }}">
                                @error('email')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('email_additional') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="email_additional">Email Address (Additional)</label>
                                <input type="email" class="form-control" id="email_additional" name="email_additional"
                                    placeholder="Enter Email Address (Additional)" value="{{ old('email_additional', $employer->email_additional) }}">
                                @error('email_additional')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="phone">Phone Number <span class="text text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Phone Number" value="{{ old('phone', $employer->phone) }}">
                                @error('phone')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                <input id="dial-code" name="dialcode" type="hidden"
                                    value="{{ isset($admin) ? $admin->dialcode : '' }}">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <h4 class="text-dark">Company Details</h4>
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('company_name') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="company_name">Company Name <span class="text text-danger">*</span></label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    placeholder="Enter Company Name" value="{{ old('company_name',$employer->company_name) }}">
                                @error('company_name')
                                    <span id="company_name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('website') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="website">WebSite Link (Optional) </label>
                                <input type="text" class="form-control" id="website" name="website"
                                    placeholder="Enter WebSite" value="{{ old('website',$employer->website) }}">
                                @error('website')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="address">Address <span class="text text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address" value="{{ old('address', $employer->address) }}">
                                @error('address')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="city">City</label>
                                <input type="text"   class="form-control" id="city" name="city"
                                    placeholder="Enter City" value="{{ old('city', $employer->city) }}">
                                @error('city')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="state">State</label>
                                <input type="text"  class="form-control" id="state" name="state"
                                    placeholder="Enter State" value="{{ old('state', $employer->state) }}">
                                @error('state')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="col-form-label" for="country">{{ __('Country') }}</label>

                                <select id="country"  class="form-select" name="iso2">
                                    <option value="">Select Country</option>
                                </select>

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="zipcode">Zipcode</label>
                                <input type="text"  class="form-control" id="zipcode" name="zipcode"
                                    placeholder="Enter Zipcode" value="{{ old('zipcode', $employer->zipcode) }}">
                                @error('zipcode')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label" for="avatar">Company Logo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="avatar" name="avatar"
                                        onchange="loadPreview(this);">
                                </div>
                                @if ($errors->has('avatar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                                <img id="preview_img" src="{{ $employer->avatar }}" class="mt-2"
                                    width="100" height="100" />
                            </div>

                            <div class="col-sm-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter Descriptions">{{ old('description',$employer->description) }}</textarea>
                                @error('description')
                                    <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-success" form="employerForm"><i
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
                        .width(100)
                        .height(100);
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
            initialCountry: "{{ old('iso2', $employer->iso2) }}",
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
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#description',
            height: 300,
            menubar: true,
            plugins: "advlist lists anchor autolink emoticons wordcount table",
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | emoticons | table | tableofcontents',
            content_style: 'body { font-size: 0.9rem; font-weight: 400; line-height: 1.5; color:#6c757d }'
        });
    </script>
@endpush
