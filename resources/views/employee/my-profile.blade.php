@extends('layouts.employee')
@section('title', 'My Profile')
@section('head')
    <link href="{{ asset('assets/css/vendor/cropper.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<h5 class="page-title">Personal Details</h5>
<section class="view_applicant">
    <div class="card">
        <div class="card-header">
            <div class="thumb-image">
                <img src="{{ $employee->avatar }}" class="avatar-lg img-thumbnail" alt="profile-image">
            </div>
            <div class="edit-companany">
                <a href="{{ route('employee.edit-profile') }}" class="btn btn-outline"><i class="fa fa-edit me-1"></i> Edit</a>
                <p>Date Joined : {{ \Carbon\Carbon::parse($employee->created_at)->format('l, M d h:i A') }}</p>
            </div>

        </div>
        <div class="card-body">
            <h4 class="jobtitle">{{ $employee->firstname }} {{ $employee->lastname }}</h4>
            <span class="companyname">{{ __('Employee') }}</span>
        </div>
    </div>
</section>
<section class="appliant_details mb-5">
    <div class="card-body">
        <div class="JobDetails">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mt-2">
                        <label><strong>Fullname</strong></label>
                        <p>{{ $employee->firstname }} {{ $employee->lastname }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Email</strong></label>
                        <p>{{ $employee->email }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Email (Additional)</strong></label>
                        <p>{{ $employee->email_additional }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Contact Number</strong></label>
                        <p>{{ $employee->phone }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Position Classification</strong></label>
                        <p>{{ $employee->positions }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>External Links</strong></label>
                        <p>{{ $employee->external_link }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mt-2">
                        <label><strong>Highest Education</strong></label>
                        <p>{{ $employee->highest_education }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Address</strong></label>
                        <p>{{ $employee->address }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>City</strong></label>
                        <p>{{ $employee->city }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>State</strong></label>
                        <p>{{ $employee->state }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Country</strong></label>
                        <p>{{ $employee->country }}</p>
                    </div>
                    <div class="form-group mt-2">
                        <label><strong>Zipcode</strong></label>
                        <p>{{ $employee->zipcode }}</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group mt-2">
                        <label><strong>Job Skills</strong></label>
                        <p class="mt-2">@if($employee->job_skill) @foreach ($employee->job_skill as $skill) <span class="badge bg-primary">{{ $skill }}</span> @endforeach @endif</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group mt-2">
                        <label><strong>Description</strong></label>
                        <p>{{ $employee->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
@endpush
