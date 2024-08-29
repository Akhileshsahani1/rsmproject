@extends('layouts.employer')
@section('title', 'Edit Profile')
@section('head')
    <link href="{{ asset('assets/css/vendor/cropper.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<h5 class="page-title">Company Details</h5>
<form id="profileForm" method="POST" action="{{ route('my-profile') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group text-center">
                <label class="label" data-toggle="tooltip" title="Change your avatar">
                    <img class="rounded" id="avatar" src="{{ $employer->avatar }}" alt="avatar">
                    <input type="file" class="sr-only" id="input" name="image" accept="image/*"
                        style="display: none;">
                </label>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-2 {{ $errors->has('company_name') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name"
                        placeholder="Enter Company Name" value="{{ old('company_name', $employer->company_name) }}">
                    @error('company_name')
                        <span id="company_name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('owner_name') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="owner_name">Owner Name</label>
                    <input type="text" class="form-control" id="owner_name" name="owner_name"
                        placeholder="Enter Owner Name" value="{{ old('owner_name', $employer->owner_name) }}">
                    @error('owner_name')
                        <span id="owner_name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter Email Address" value="{{ old('email', $employer->email) }}">
                    @error('email')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('email_additional') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="email_additional">Email Address (Additional)</label>
                    <input type="email" class="form-control" id="email_additional" name="email_additional"
                        placeholder="Enter Email Address (Additional)"
                        value="{{ old('email_additional', $employer->email_additional) }}">
                    @error('email_additional')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        placeholder="Enter Phone Number" value="{{ old('phone', $employer->phone) }}">
                    @error('phone')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                    <input id="dial-code" name="dialcode" type="hidden"
                        value="{{ isset($admin) ? $admin->dialcode : '' }}">
                </div>

                <div class="col-sm-6 mb-2 {{ $errors->has('website') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="website">Website</label>
                    <input type="text" class="form-control" id="website" name="website"
                        placeholder="Website" value="{{ old('website', $employer->website) }}">
                    @error('website')
                        <span id="website-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 mb-2  {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="description">About Company</label>
                    <textarea class="form-control" id="description" name="description"
                        placeholder="Please write about company here.">{{ old('description', $employer->description) }}</textarea>
                    @error('description')
                        <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>

    </div>
    <h5 class="page-title my-2">Contact Details</h5>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address"
                        placeholder="Enter Address" value="{{ old('address', $employer->address) }}">
                    @error('address')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="city">City</label>
                    <input type="text" class="form-control"  id="city" name="city" placeholder="Enter City"
                        value="{{ old('city', $employer->city) }}">
                    @error('city')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="state">State</label>
                    <input type="text" class="form-control"  id="state" name="state" placeholder="Enter State"
                        value="{{ old('state', $employer->state) }}">
                    @error('state')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2">
                    <label class="col-form-label"  for="country">{{ __('Country') }}</label>

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
                    <input type="text" class="form-control"  id="zipcode" name="zipcode"
                        placeholder="Enter Zipcode" value="{{ old('zipcode', $employer->zipcode) }}">
                    @error('zipcode')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ url('/my-profile') }}" class="btn btn-outline-primary me-1"><i
                    class="mdi mdi-chevron-double-left me-1"></i>Back</a>
            <button type="submit" class="btn btn-primary" form="profileForm"><i
                    class="mdi mdi-database me-1"></i>Update</button>
        </div>
    </div>
</form>
    <div class="modal " id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="image" src="{{ $employer->avatar }}" style="max-width: 100%">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Upload</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/vendor/cropper.js') }}"></script>
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
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var avatar = document.getElementById('avatar');
            var image = document.getElementById('image');
            var input = document.getElementById('input');
            var $progress = $('.progress');
            var $progressBar = $('.progress-bar');
            var $alert = $('.alert');
            var $modal = $('#modal');
            var cropper;

            $('[data-toggle="tooltip"]').tooltip();

            input.addEventListener('change', function(e) {
                var files = e.target.files;
                var done = function(url) {
                    input.value = '';
                    image.src = url;
                    $alert.hide();
                    $modal.modal('show');
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 0,
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            document.getElementById('crop').addEventListener('click', function() {
                var initialAvatarURL;
                var canvas;

                $modal.modal('hide');

                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160,
                    });
                    initialAvatarURL = avatar.src;
                    avatar.src = canvas.toDataURL();
                    $progress.show();
                    $alert.removeClass('alert-success alert-warning');
                    canvas.toBlob(function(blob) {
                        url = URL.createObjectURL(blob);
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function() {
                            var base64data = reader.result;
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "{{ route('upload-avatar') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                data: {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'image': base64data
                                },
                                success: function(data) {
                                    $modal.modal('hide');
                                    // alert("Image successfully uploaded");
                                }
                            });
                        }
                    });
                }
            });
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
