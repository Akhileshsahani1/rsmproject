@extends('layouts.app')
@section('title', 'Onboarding')
@section('head')
    <link href="{{ asset('assets/css/vendor/cropper.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-6">
                <div class="card">

                    <!-- Logo -->

                    <div class="card-header bg-blue text-white text-center">
                        <h5 class="card-title  mb-0">Onboarding</h5>
                        <p class="mb-0">Welcome {{ $employer->company_name }}</p>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center w-85 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold"></h4>
                            <p class="text-muted mb-2">Enter the following details to complete your profile.</p>
                        </div>
                        <div class="form-group text-center">
                            <label class="label" data-toggle="tooltip" title="Change Company Logo">
                                <img class="rounded" id="avatar" src="{{ $employer->avatar }}" alt="avatar">
                                <input type="file" class="sr-only" id="input" name="image" accept="image/*"
                                    style="display: none;">
                            </label>
                        </div>
                        <form action="{{ route('onboarding.process') }}" method="POST" enctype="multipart/form-data"
                            id="profileForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 mb-1">
                                    <label for="owner_name" class="col-form-label">{{ __('Owner Name') }}</label>

                                    <input id="owner_name" type="text"
                                        class="form-control @error('owner_name') is-invalid @enderror" name="owner_name"
                                        value="{{ old('owner_name', $employer->owner_name) }}" placeholder="Enter Owner Name"
                                        autocomplete="owner_name" autofocus>

                                    @error('owner_name')
                                        <span id="website-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-1 {{ $errors->has('website') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="website">Website Link</label>
                                    <input type="text" class="form-control" id="website" name="website"
                                        placeholder="Enter Website Link" value="{{ old('website', $employer->website) }}">
                                    @error('website')
                                        <span id="website-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-1 {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter Address" value="{{ old('address', $employer->address) }}">
                                    @error('address')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-1 {{ $errors->has('city') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Enter your city" value="{{ old('city', $employer->city) }}">
                                    @error('city')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-1 {{ $errors->has('state') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="Enter your state" value="{{ old('state', $employer->state) }}">
                                    @error('state')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-1 {{ $errors->has('country') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="country">{{ __('Country') }}</label>

                                    <select id="country" class="form-select" name="country">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->code }}"
                                                {{ old('country', $employer->iso2) == $country->code ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-1 {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                                        placeholder="Enter Zipcode" value="{{ old('zipcode', $employer->zipcode) }}">
                                    @error('zipcode')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-end">
                        {{-- <a href="/" class="btn btn-sm btn-warning me-1">Skip</a> --}}
                        <button type="submit" class="btn btn-sm btn-success" form="profileForm">Save & Continue</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
@endpush
