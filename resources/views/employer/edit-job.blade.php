@extends('layouts.app')
@section('title', 'Edit Job')
@section('content')
    <style>
        body {
            background: #f3f3f3;
        }
    </style>
    <div class="container">
        <h5 class="login-title">Edit Job</h5>
        <div class="post-form">
            <form id="jobForm" method="POST" action="{{ route('update-job',$job->id) }}" enctype="multipart/form-data">
                @csrf
                <h5 class="page-title">Job Details</h5>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="text-danger text-center">Warning: Please Fill Job Form Correctly.</div>
                    @endif
                    <div class="row">

                        <div class="col-sm-6 mb-2 {{ $errors->has('position_name') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="position_name">Position Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="position_name" name="position_name"
                                placeholder="Enter Position Name" value="{{ old('position_name',$job->position_name) }}">
                            @error('position_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2 {{ $errors->has('preferred_classification') ? 'has-error' : '' }}">
                            <label for="preferred_classification" class="col-form-label">Preferred
                                classification <span class="text-danger">*</span></label>
                            <select id="preferred_classification"
                                class="form-control @error('preferred_classification') is-invalid @enderror"
                                name="preferred_classification" onchange="getSubclassifications();">
                                <option></option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->id }}"
                                        {{ old('preferred_classification',$job->classification_id) == $classification->id ? 'selected' : '' }}>
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
                            <label class="col-form-label" for="sub_classification">{{ __('Sub-classification') }} <span
                                    class="text-danger">*</span></label>

                            <select id="sub_classification" class="form-select" name="sub_classification">
                                <option value="">Select Sub-classification</option>
                            </select>

                            @error('sub_classification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2 {{ $errors->has('no_of_position') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="no_of_position">Number of Position <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="no_of_position" name="no_of_position"
                                placeholder="Enter Number of Positions" value="{{ old('no_of_position', $job->no_of_position) }}"
                                min="1">
                            @error('no_of_position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label class="col-form-label" for="position_type">{{ __('Position Type') }} <span
                                    class="text-danger">*</span></label>
                            <select id="position_type" class="form-select" name="position_type">
                                <option value="">Select Position Type</option>
                                <option value="Part Time" {{ old('position_type',$job->position_type) == 'Part Time' ? 'selected' : '' }}>
                                    Part Time</option>
                                <option value="Full Time" {{ old('position_type',$job->position_type) == 'Full Time' ? 'selected' : '' }}>
                                    Full Time
                                </option>
                                <option value="Contract" {{ old('position_type',$job->position_type) == 'Contract' ? 'selected' : '' }}>
                                    Contract</option>
                                <option value="Casual" {{ old('position_type',$job->position_type) == 'Casual' ? 'selected' : '' }}>
                                    Casual</option>
                            </select>
                            @error('position_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2 {{ $errors->has('contract_days') ? 'has-error' : '' }}"
                            id="contract_days_div">
                            <label class="col-form-label" for="contract_days">Contract Days <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="contract_days" name="contract_days"
                                placeholder="Enter Contract Days" value="{{ old('contract_days',$job->contract_days) }}" min="1">
                            @error('contract_days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label class="col-form-label" for="shift_type">{{ __('Shift Type') }} <span
                                    class="text-danger">*</span></label>
                            <select id="shift_type" class="form-select" name="shift_type">
                                <option value="">Select Shift Type</option>
                                <option value="First Shift (Day)"
                                    {{ old('shift_type',$job->shift_type) == 'First Shift (Day)' ? 'selected' : '' }}>
                                    First Shift (Day)</option>
                                <option value="Second Shift (Afternoon)"
                                    {{ old('shift_type',$job->shift_type) == 'Second Shift (Afternoon)' ? 'selected' : '' }}>
                                    Second Shift (Afternoon)
                                </option>
                                <option value="Third Shift (Night)"
                                    {{ old('shift_type',$job->shift_type) == 'Third Shift (Night)' ? 'selected' : '' }}>
                                    Third Shift (Night)</option>
                            </select>
                            @error('shift_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label class="col-form-label" for="salary_type">{{ __('Salary Type') }} <span
                                    class="text-danger">*</span></label>
                            <select id="salary_type" class="form-select" name="salary_type">
                                <option value="">Select Salary Type</option>
                                <option value="Month Range" {{ old('salary_type',$job->salary_type) == 'Month Range' ? 'selected' : '' }}>
                                    Month Range</option>
                                <option value="Month Fixed" {{ old('salary_type',$job->salary_type) == 'Month Fixed' ? 'selected' : '' }}>
                                    Month Fixed
                                </option>
                                <option value="Day Range" {{ old('salary_type',$job->salary_type) == 'Day Range' ? 'selected' : '' }}>
                                    Day Range</option>
                                <option value="Day Fixed" {{ old('salary_type',$job->salary_type) == 'Day Fixed' ? 'selected' : '' }}>
                                    Day Fixed</option>
                                <option value="Hourly" {{ old('salary_type',$job->salary_type) == 'Hourly' ? 'selected' : '' }}>Hourly
                                </option>
                                <option value="Contracted Value"
                                    {{ old('salary_type',$job->salary_type) == 'Contracted Value' ? 'selected' : '' }}>Contracted Value
                                </option>
                            </select>
                            @error('salary_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 salary-range mb-2 {{ $errors->has('start') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="start">Start <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="start" name="start"
                                placeholder="Enter Start" value="{{ old('start',$job->start) }}" min="1">
                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 salary-range mb-2 {{ $errors->has('end') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="end">End <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="end" name="end"
                                placeholder="Enter End" value="{{ old('end',$job->end) }}" min="1">
                            @error('end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label class="col-form-label" for="career_level">{{ __('Career Level') }} <span
                                    class="text-danger">*</span></label>
                            <select id="career_level" class="form-select" name="career_level">
                                <option value="">Select Career Level</option>
                                <option value="Entry Level" {{ old('career_level',$job->career_level) == 'Entry Level' ? 'selected' : '' }}>
                                    Entry Level</option>
                                <option value="Mid Level" {{ old('career_level',$job->career_level) == 'Mid Level' ? 'selected' : '' }}>
                                    Mid Level
                                </option>
                                <option value="Experienced Professional"
                                    {{ old('career_level',$job->career_level) == 'Experienced Professional' ? 'selected' : '' }}>
                                    Experienced Professional</option>
                            </select>
                            @error('career_level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-2" style="display: none;">
                            <label class="col-form-label" for="gender">{{ __('Gender') }} <span
                                    class="text-danger">*</span></label>

                            <select id="gender" class="form-select" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender',$job->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender',$job->gender) == 'Female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="Other" {{ old('gender',$job->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>

                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>



                <h5 class="page-title">Job Location</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2 {{ $errors->has('location') ? 'has-error' : '' }}">
                            <label for="location" class="col-form-label">Location <span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <div class="input-group-text">
                                    <i class="uil-map-pin-alt"></i>
                                </div>
                                <input id="latitude" type="hidden" class="form-control" name="latitude"
                                    value="{{ old('latitude',$job->latitude) }}">
                                <input id="longitude" type="hidden" class="form-control" name="longitude"
                                    value="{{ old('longitude',$job->longitude) }}">
                                <input id="location" type="text"
                                    class="form-control @error('location') is-invalid @enderror" name="location"
                                    value="{{ old('location',$job->location) }}" autocomplete="off" placeholder="Start Address">
                            </div>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2 {{ $errors->has('region') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="region">Region <span
                                    class="text-danger">*</span></label>
                            <select name="region" id="region" class="form-select" onchange="getAreas();">
                                <option value="">Select Region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}"
                                        {{ old('region',$job->region_id) == $region->id ? 'selected' : '' }}>{{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('region')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2 {{ $errors->has('area') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="area">Area <span class="text-danger">*</span></label>
                            <select name="area" id="area" class="form-select" onchange="getSubzones();">
                                <option value="">Select Area</option>
                            </select>
                            @error('area')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2 {{ $errors->has('subzone') ? 'has-error' : '' }}">
                            <label class="col-form-label" for="subzone">Subzone <span
                                    class="text-danger">*</span></label>
                            <select name="subzone" id="subzone" class="form-select">
                                <option value="">Select subzone</option>
                            </select>
                            @error('subzone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>



                <h5 class="page-title">Required Skills and Education</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <label class="col-form-label" for="skills">{{ __('Education') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-control select2" data-toggle="select2" name="education"
                                data-placeholder="Select Education">
                                <option value="">Select Education</option>

                                @foreach ($educations as $edu)
                                    <option value="{{ $edu }}" {{ old('education',$job->education) == $edu ? 'selected' : '' }}>
                                        {{ $edu }}</option>
                                @endforeach

                            </select>
                            @error('education')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-12 mb-2">
                            <label class="col-form-label" for="skills">{{ __('Skills') }} <span
                                    class="text-danger">*</span></label>
                            {{-- <select name="skills[]" class="select2 form-control select2-multiple" data-toggle="select2"
                                multiple="multiple" data-placeholder="Skills">
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill }}"
                                        @if (old('skills')) {{ in_array($skill, old('skills')) ? 'selected' : '' }} @endif>
                                        {{ $skill }}</option>
                                @endforeach
                            </select> --}}
                             <div class="row">
                                    <div class="col-sm-12">
                                        <div id="div-skills">
                                            @foreach($job->skills_required as $skill)
                                            <div class="custom-skill" id="skill-{{ $skill }}">
                                               <li class="skill-li">{{ $skill }}
                                                <input type="hidden" name="skills[]" value={{ $skill }}>
                                                <span onclick="$('#skill-{{ $skill }}').remove()">
                                                 <i class="dripicons-cross"></i>
                                                 </span>
                                                </li>
                                             </div>
                                         @endforeach
                                        </div>
                                    </div>
                                    <div class="col-sm-10   ">
                                        <input type="text" class="form-control" data-provide="typeahead" id="the-basics" placeholder="Add Skill">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-success" id="add-skill">Add Skill</button>
                                    </div>
                                </div>
                            @error('skills')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>


                <h5 class="page-title">Salary and Other Details</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 mb-2">
                            <label class="col-form-label" for="salary_from">{{ __('Salary From') }} <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="salary_from" type="number" name="salary_from"
                                value="{{ old('salary_from', $job->salary_from) }}" step="any">
                            @error('salary_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label class="col-form-label" for="salary_upto">{{ __('Salary Upto') }} <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="salary_upto" type="number" name="salary_upto"
                                value="{{ old('salary_upto', $job->salary_upto) }}" step="any">
                            @error('salary_upto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-4 mb-2">
                            <label class="col-form-label" for="hide_salary">{{ __('Hide Salary from Post') }} <span
                                    class="text-danger">*</span></label>
                            <select id="hide_salary" class="form-select" name="hide_salary">
                                <option value="0" {{ old('hide_salary',$job->hide_salary) == '0' ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ old('hide_salary',$job->hide_salary) == '1' ? 'selected' : '' }}>
                                    Yes</option>

                            </select>
                            @error('hide_salary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label class="col-form-label" for="working_days">{{ __('Working Days') }} <span
                                    class="text-danger">*</span></label>
                            <select name="working_days[]" class="select2 form-control select2-multiple"
                                data-toggle="select2" multiple="multiple" data-placeholder="Select Working Days">
                                @foreach ($working_days as $day)
                                    <option value="{{ $day }}"
                                        {{ collect(old('working_days',$job->working_days))->contains($day) ? 'selected' : '' }}>
                                        {{ $day }}</option>
                                @endforeach
                            </select>
                            @error('working_days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label class="col-form-label" for="working_hours">{{ __('Start Time') }} <span
                                    class="text-danger">*</span></label>
                            <input class="form-control timepicker-bs4" id="working_start_hours" type="text"
                                name="working_start_hour" value="{{ old('working_start_hour',$job->working_start_hour) }}"
                                placeholder="start Hour" autocomplete="off">

                            @error('working_start_hours')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label class="col-form-label" for="working_hours">{{ __('End Time') }} <span
                                    class="text-danger">*</span></label>
                            <input class="form-control timepicker-bs4" id="working_end_hours" type="text"
                                name="working_end_hour" value="{{ old('working_end_hour',$job->working_end_hour) }}"
                                placeholder="end Hour" autocomplete="off">

                            @error('working_end_hours')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>



                <h5 class="page-title">Job Description</h5>
                <div class="card-body">
                    <textarea class="form-control" id="description" rows="4" name="description">{{ old('description',$job->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <h5 class="page-title">Job Benefits</h5>
                <div class="card-body">
                    <textarea class="form-control" id="benefits" rows="4" name="benefits">{{ old('benefits',$job->benefits) }}</textarea>
                    @error('benefits')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="card-footer d-grid">
                    <button type="submit" class="btn btn-primary" form="jobForm"><i
                            class="mdi mdi-database me-1"></i>Post Job</button>
                </div>
        </div>
        </form>
    </div>


    </div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/vendor/handlebars.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/typeahead.bundle.min.js') }}"></script>
    <script>
        $('#position_type').on('change', function() {
            showContractDays()
        });

        function showContractDays() {
            let value = $('#position_type').val();
            if (value == 'Contract') {
                $('#contract_days_div').css('display', 'block');
            } else {
                $('#contract_days_div').css('display', 'none');
            }
        }
        showContractDays();
    </script>
    <script>
        $('#salary_type').on('change', function() {
            showStartEnd()
        });

        function showStartEnd() {
            let value = $('#salary_type').val();
            if (value == 'Month Range' || value == 'Day Range') {
                $('.salary-range').css('display', 'block');
            } else {
                $('.salary-range').css('display', 'none');
            }
        }
        showStartEnd();
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_api_key') }}&libraries=places&callback=Function.prototype">
    </script>
    <script>
        let location_element = document.getElementById('location')
        let autocomplete = new google.maps.places.Autocomplete(location_element);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            $('#latitude').val(place.geometry.location.lat())
            $('#longitude').val(place.geometry.location.lng())
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
    <script>
        tinymce.init({
            selector: 'textarea#benefits',
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
        function getAreas() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                }
            });
            var formData = {
                region_id: $('#region').val(),
            };
            $.ajax({
                type: 'POST',
                url: "{{ route('get-areas') }}",
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log('Before Sending Request');
                },
                success: function(res, status) {
                    $('#area').html(res);
                    $('#area').val('{{ old('area',$job->area_id) }}');
                    getSubzones();

                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>
    <script>
        function getSubzones() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                }
            });
            var formData = {
                area_id: $('#area').val(),
            };
            $.ajax({
                type: 'POST',
                url: "{{ route('get-sub-zones') }}",
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    console.log('Before Sending Request');
                },
                success: function(res, status) {
                    $('#subzone').html(res);
                    $('#subzone').val('{{ old('subzone',$job->sub_zone_id) }}');
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
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
                    $('#sub_classification').val('{{ old('sub_classification',$job->sub_classification_id) }}');
                },
                error: function(res, status) {
                    console.log(res);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            getSubclassifications();
            getAreas();
        });
    </script>
    <script>
        $("#preferred_classification").select2({
            placeholder: "Select Classification"
        });
        $("#sub_classification").select2({
            placeholder: "Select Sub-classification"
        });
        $("#area").select2({
            placeholder: "Select Area"
        });
        $("#subzone").select2({
            placeholder: "Select Subzone"
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
           var skills = document.getElementsByName('skills[]');
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
           html += '<input type="hidden" name="skills[]" value='+value+'> <span onclick=$("#skill-'+value+'").remove()><i class="dripicons-cross"></i></span></li></div>';

           $('#the-basics').val('');
           $('#div-skills').append(html);
          }
        });
    </script>
@endpush
