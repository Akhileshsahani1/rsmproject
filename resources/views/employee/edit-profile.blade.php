@extends('layouts.employee')
@section('title', 'Edit Profile')
@section('head')
    <link href="{{ asset('assets/css/vendor/cropper.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<h5 class="page-title">Personal Details</h5>
<form id="profileForm" method="POST" action="{{ route('employee.my-profile') }}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group text-center">
                <label class="label" data-toggle="tooltip" title="Change your avatar">
                    <img class="rounded" id="avatar" src="{{ $employee->avatar }}" alt="avatar">
                    <input type="file" class="sr-only" id="input" name="image" accept="image/*"
                        style="display: none;">
                </label>
            </div>
            <div class="row">
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
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name"
                        value="{{ old('lastname', $employee->lastname) }}">
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
                        <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>
                            Female
                        </option>
                        <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>
                            Other</option>
                    </select>

                    @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-sm-6 mb-2 {{ $errors->has('external_link') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="external_link">External Links</label>
                    <input type="text" class="form-control" id="external_link" name="external_link"
                        placeholder="External Links" value="{{ old('external_link', $employee->external_link) }}">
                    @error('external_link')
                        <span id="external_link-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>

    </div>
    <h5 class="page-title my-2">About your next role</h5>
    <div class="card ">
        <div class="card-body">
            <div class="row">
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
                    <label class="col-form-label" for="sub_classification">{{ __('Sub-classification') }}</label>

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
                <div class="col-sm-12 mb-2 {{ $errors->has('highest_education') ? 'has-error' : '' }}">
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
                        <span id="highest_education-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-12 mb-2 {{ $errors->has('job_skills') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="job_skills">Job Skills</label>
                    {{-- <select class="form-control" id="job_skills" name="job_skills[]" multiple>

                        <option value="PHP"
                            {{ in_array('PHP', isset($employee->job_skill) ? $employee->job_skill : []) ? 'selected' : '' }}>
                            PHP</option>



                    </select> --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="div-skills">
                                @if(isset($employee->job_skill))
                                @foreach($employee->job_skill as $skill)
                                   <div class="custom-skill" id="skill-{{ $skill }}">
                                      <li class="skill-li">{{ $skill }}
                                       <input type="hidden" name="job_skill[]" value={{ $skill }}>
                                       <span onclick="$('#skill-{{ $skill }}').remove()">
                                        <i class="dripicons-cross"></i>
                                        </span>
                                       </li>
                                    </div>
                                @endforeach
                                @endif

                            </div>
                        </div>
                        <div class="col-sm-10   ">
                            <input type="text" class="form-control" data-provide="typeahead" id="the-basics" placeholder="Add Skill">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" id="add-skill">Add Skill</button>
                        </div>
                    </div>
                    @error('job_skill')
                        <span id="job_skills-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-12 mb-2  {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="description">Personal summary</label>
                    <textarea class="form-control" id="description" name="description"
                        placeholder="Add a personal summary to your profile as a way to introduce who you are.">{{ old('description', $employee->description) }}</textarea>
                    @error('description')
                        <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-12 mb-2">
                    <label class="col-md-3 col-form-label text-md-start">{{ __('Documents') }}</label>
                    <div class="col-md-9">
                        <input id="documents" type="file"
                            class="form-control @error('documents') is-invalid @enderror" name="documents[]" multiple
                            style="display: none">
                        <label class="border mb-2" for="documents">
                            <img src="{{ asset('assets/images/document-placeholder.png') }}"></label>
                        <span class="document-list d-flex">

                        </span>
                        <span class="uploaded-document-list d-flex">
                            @foreach ($employee->documents as $document)
                                <span class="me-2 mt-2 mb-2 border text-center py-4 document-{{ $document->id }}"
                                    style="width: 150px; height: 100px; position: relative;"><i class="fa fa-close"
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
            </div>
        </div>
    </div>

    <div class="card my-2">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 my-2">
                    <section class="p-2" style="background-color: #EBE6EE">
                        <h3>Be found by employers</h3>
                        <p>Your profile visibility setting controls if you can be approached by employers
                            and recruiters with job opportunities.</p>
                        <select id="profile_visibility" class="form-select mb-2" name="profile_visibility">
                            <option value="">Select Visibility</option>
                            <option value="Show Profile"
                                {{ old('profile_visibility', $employee->profile_visibility) == 'Show Profile' ? 'selected' : '' }}>
                                Show Profile (Recommended)
                            </option>
                            <option value="Hidden"
                                {{ old('profile_visibility', $employee->profile_visibility) == 'Hidden' ? 'selected' : '' }}>
                                Hide Profile
                            </option>
                        </select>
                        @error('profile_visibility')
                            <span id="profile_visibility-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p>For all settings, your Profile including any verified credentials will be sent to
                            the employer with your applications.</p>
                    </section>
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
                        placeholder="Enter Address" value="{{ old('address', $employee->address) }}">
                    @error('address')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"
                        value="{{ old('city', $employee->city) }}">
                    @error('city')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                    <label class="col-form-label" for="state">State</label>
                    <input type="text" class="form-control" id="state" name="state" placeholder="Enter State"
                        value="{{ old('state', $employee->state) }}">
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
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary me-1"><i
                    class="mdi mdi-chevron-double-left me-1"></i>Back</a>
            <button type="submit" class="btn btn-primary" form="profileForm"><i
                    class="mdi mdi-database me-1"></i>Update</button>
        </div>
    </div>
</form>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
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
                        <img id="image" src="{{ $employee->avatar }}" style="max-width: 100%">
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
    <script src="{{ asset('assets/js/vendor/handlebars.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/typeahead.bundle.min.js') }}"></script>
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
                                url: "{{ route('employee.upload-avatar') }}",
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
        $("#locations").select2({
            placeholder: "Choose Locations"
        });
    </script>
    <script>
        $("#nationality").select2({
            placeholder: "Choose Nationality"
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
     <script>
        function showExperienceDiv() {
            if ($("#experience").is(':checked')) {
                $("#experience_div").show();
            } else {
                $("#experience_div").hide();
            }
        }
    </script>
    <script>
        function showStillInRoleDiv() {
            if ($("#still_in_role").is(':checked')) {
                $(".ended_div").hide();
            } else {
                $(".ended_div").show();
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            showExperienceDiv();
            showStillInRoleDiv();
        });
    </script>
     <script type="text/javascript">
        var o, e = [
             @foreach($skills as $skill)
             "{{ $skill }}",
             @endforeach
        ];
       $("#the-basics").typeahead({
           hint: !0,
           highlight: !0,
           minLength: 1
       }, {
           name: "states",
           source: (o = e, function(e, a) {
               var t = [];
               substrRegex = new RegExp(e, "i"), $.each(o, function(e, a) {
                   substrRegex.test(a) && t.push(a)
               }), a(t)
           })
       });
       $('#add-skill').on('click',function(){
          let value =$('#the-basics').val();
          var skills = document.getElementsByName('job_skill[]');
          let exist = true;
          for(var x = 0, l = skills.length; x < l;  x++)
           {
               if(skills[x].value == value){
                   exist = false;
                   $('#the-basics').val('');
               }
           }
          if(value && exist){
          let html  = '<div class="custom-skill" id="skill-'+value+'"><li class="skill-li">'+value;
          html += '<input type="hidden" name="job_skill[]" value='+value+'> <span onclick=$("#skill-'+value+'").remove()><i class="dripicons-cross"></i></span></li></div>';

          $('#the-basics').val('');
          $('#div-skills').append(html);
         }
       });
   </script>
@endpush
