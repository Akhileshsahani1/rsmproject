@extends('layouts.admin')
@section('title', 'Edit Employee')
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
                        <a href="{{ route('admin.employees.index', ['status' => $employee->status]) }}"
                            class="btn btn-sm btn-dark me-1"><i class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-success" form="employeeForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Employee</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

    </div> <!-- container -->

    <div class="row">
        <div class="col-12">
            <form id="employeeForm" method="POST" action="{{ route('admin.employees.update', $employee->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <h4 class="text-dark">Personal Details</h4>
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('firstname') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="Enter First Name" value="{{ old('firstname', $employee->firstname) }}">
                                @error('firstname')
                                    <span id="firstname-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('lastname') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="lastname">Lastname</label>
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    placeholder="Enter Last Name" value="{{ old('lastname', $employee->lastname) }}">
                                @error('lastname')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email Address" value="{{ old('email', $employee->email) }}">
                                @error('email')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('email_additional') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="email_additional">Email Address (Additional)</label>
                                <input type="email" class="form-control" id="email_additional" name="email_additional"
                                    placeholder="Enter Email Address (Additional)"
                                    value="{{ old('email_additional', $employee->email_additional) }}">
                                @error('email_additional')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Phone Number" value="{{ old('phone', $employee->phone) }}">
                                @error('phone')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                <input id="dial-code" name="dialcode" type="hidden"
                                    value="{{ isset($admin) ? $admin->dialcode : '' }}">
                            </div>
                            <div class="col-sm-6 mb-1 {{ $errors->has('nationality') ? 'has-error' : '' }}">
                                <label for="nationality" class="col-form-label">Nationality</label>
                                <select id="nationality" class="form-control @error('nationality') is-invalid @enderror"
                                    name="nationality">
                                    <option value="">Choose your nationality</option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->nationality }}"
                                            {{ old('nationality', $employee->nationality) == $nationality->nationality ? 'selected' : '' }}>
                                            {{ $nationality->nationality }}</option>
                                    @endforeach
                                </select>
                                @error('nationality')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="col-form-label" for="gender">{{ __('Gender') }}</label>

                                <select id="gender" class="form-select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male"
                                        {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female"
                                        {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="Other"
                                        {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('preferred_classification') ? 'has-error' : '' }}">
                                <label for="preferred_classification" class="col-form-label">Preferred
                                    classification</label>
                                <select id="preferred_classification"
                                    class="form-control @error('preferred_classification') is-invalid @enderror"
                                    name="preferred_classification" onchange="getSubclassifications();">
                                    <option value="">Select Classification</option>
                                    @foreach ($classifications as $classification)
                                        <option value="{{ $classification->id }}"
                                            {{ old('preferred_classification', $employee->classification_id) == $classification->id ? 'selected' : '' }}>
                                            {{ $classification->classification }}</option>
                                    @endforeach
                                </select>
                                @error('preferred_classification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('sub_classification') ? 'has-error' : '' }}">
                                <label class="col-form-label"
                                    for="sub_classification">{{ __('Sub-classification') }}</label>

                                <select id="sub_classification" class="form-select" name="sub_classification">
                                    <option value="">Select Sub-classification</option>
                                    @foreach ($subclassifications as $subclassification)
                                    <option value="{{ $subclassification->id }}"
                                        {{ old('sub_classification', $employee->sub_classification_id) == $subclassification->id ? 'selected' : '' }}>
                                        {{ $subclassification->sub_classification }}</option>
                                @endforeach
                                </select>

                                @error('sub_classification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('external_link') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="external_link">External Links</label>
                                <input type="text" class="form-control" id="external_link" name="external_link"
                                    placeholder="External Links"
                                    value="{{ old('external_link', $employee->external_link) }}">
                                @error('external_link')
                                    <span id="external_link-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-2 {{ $errors->has('highest_education') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="highest_education">Highest Education</label>
                                <select class="form-control" name="highest_education">
                                    <option value="None"
                                        {{ old('highest_education', $employee->highest_education) == 'None' ? 'selected' : '' }}>
                                        None</option>
                                    <option value="PSLE"
                                        {{ old('highest_education', $employee->highest_education) == 'PSLE' ? 'selected' : '' }}>
                                        PSLE</option>
                                    <option value="GCE O-Level"
                                        {{ old('highest_education', $employee->highest_education) == 'GCE O-Level' ? 'selected' : '' }}>
                                        GCE O-Level</option>
                                    <option value="GCE N-Level"
                                        {{ old('highest_education', $employee->highest_education) == 'GCE N-Level' ? 'selected' : '' }}>
                                        GCE N-Level</option>
                                    <option value="GCE A-Level"
                                        {{ old('highest_education', $employee->highest_education) == 'GCE A-Level' ? 'selected' : '' }}>
                                        GCE A-Level</option>
                                    <option value="Diploma"
                                        {{ old('highest_education', $employee->highest_education) == 'Diploma' ? 'selected' : '' }}>
                                        Diploma</option>
                                    <option value="Degree"
                                        {{ old('highest_education', $employee->highest_education) == 'Degree' ? 'selected' : '' }}>
                                        Degree</option>
                                </select>
                                @error('highest_education')
                                    <span id="highest_education-error"
                                        class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-2 {{ $errors->has('job_skills') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="job_skills">Job Skills</label>
                                <select class="form-control" id="job_skills" name="job_skills[]" multiple>                                   

                                    <option value="PHP" {{ in_array('PHP', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>
                                        PHP</option>
                                    <option value="NODE" {{ in_array('NODE', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>
                                        NODE</option>
                                    <option value="LARAVEL"
                                        {{ in_array('LARAVEL', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>LARAVEL
                                    </option>

                                    <option value="JQUERY" {{ in_array('JQUERY', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>
                                        JQUERY
                                    </option>
                                    <option value="REACT" {{ in_array('REACT', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>
                                        REACT
                                    </option>
                                    <option value="ANGULAR"
                                        {{ in_array('ANGULAR', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>ANGULAR
                                    </option>
                                    <option value="WORDPRESS"
                                        {{ in_array('WORDPRESS', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>WORDPRESS
                                    </option>
                                </select>
                                @error('job_skills')
                                    <span id="job_skills-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-sm-12  {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter Descriptions">{{ old('description', $employee->description) }}</textarea>
                                @error('description')
                                    <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mb-2">
                                <label class="col-md-3 col-form-label text-md-start">{{ __('Documents') }}</label>
                                <div class="col-md-9">
                                    <input id="documents" type="file"
                                        class="form-control @error('documents') is-invalid @enderror" name="documents[]"
                                        multiple style="display: none">
                                    <label class="border mb-2" for="documents">
                                        <img src="{{ asset('assets/images/document-placeholder.png') }}"></label>
                                    <span class="document-list d-flex">

                                    </span>
                                    <span class="uploaded-document-list d-flex">
                                        @foreach ($employee->documents as $document)
                                            <span
                                                class="me-2 mt-2 mb-2 border text-center py-4 document-{{ $document->id }}"
                                                style="width: 150px; height: 100px; position: relative;"><i
                                                    class="fa fa-close"
                                                    style="position: absolute;
                                                top: 7px;
                                                right: 7px;"
                                                    onclick="confirmDelete({{ $document->id }})"></i><a
                                                    href="{{ asset('storage/uploads/employees/' . $employee->slug . '/documents' . '/' . $document->name) }}"
                                                    download="">{{ $document->name }}</a></span>
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label" for="avatar">Profile Picture</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="avatar" name="avatar"
                                        onchange="loadPreview(this);">
                                </div>
                                @if ($errors->has('avatar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                                <img id="preview_img" src="{{ $employee->avatar }}" class="mt-2" width="100"
                                    height="100" />
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <h4 class="text-dark">Contact Details</h4>
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address" value="{{ old('address', $employee->address) }}">
                                @error('address')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    placeholder="Enter City" value="{{ old('city', $employee->city) }}">
                                @error('city')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state"
                                    placeholder="Enter State" value="{{ old('state', $employee->state) }}">
                                @error('state')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="col-form-label" for="country">{{ __('Country') }}</label>

                                <select id="country" class="form-select" name="iso2">
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
                                <input type="text" class="form-control" id="zipcode" name="zipcode"
                                    placeholder="Enter Zipcode" value="{{ old('zipcode', $employee->zipcode) }}">
                                @error('zipcode')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-success" form="employeeForm"><i
                                class="mdi mdi-database me-1"></i>Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            initialCountry: "{{ old('iso2', $employee->iso2) }}",
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

    <script>
        $(function() {
            // Multiple images preview in browser
            var documentsPreview = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        $($.parseHTML('<span>')).css('width', '150px')
                            .css('height', '100px').attr('class', 'me-2 mt-2 mb-2 border text-center py-4')
                            .text(input.files[i].name).appendTo(
                                placeToInsertImagePreview);

                    }

                }

            };

            $('#documents').on('change', function() {
                $('.document-list').html('')
                documentsPreview(this, 'span.document-list');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            getSubclassifications();
            $('#job_skills').select2({
                tags: true,
                tokenSeparators: [',', ' '],
            });
            $("#nationality").select2({
                placeholder: "Choose Nationality"
            });
        });

        function confirmDelete(documnet_id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && ($.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.employees.document-delete') }}",
                    data: {
                        document_id: documnet_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(e) {
                        $('.document-' + documnet_id).remove();
                    }
                }))
            })
        }
    </script>
    <script>
        function getSubclassifications() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                }
            });
            var formData = {
                classification_id: $('#preferred_classification').val(),
            };
            $.ajax({
                type: 'POST',
                url: "{{ route('get-sub-classifications') }}",
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log('Before Sending Request');
                },
                success: function(res, status) {
                    $('#sub_classification').html(res);
                    $('#sub_classification').val('{{ $employee->sub_classification_id }}')
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>
@endpush