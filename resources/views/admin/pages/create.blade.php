@extends('layouts.admin')
@section('title', 'Add Page')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-warning me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-dark" form="pageForm"><i
                                class="mdi mdi-database me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Add Page</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

        <form id="pageForm" method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="name">Page Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-2 {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label class="col-form-label" for="name">Page Content</label>
                                <textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>                 

                    <div class="card accordion custom-accordion">
                        <div class="card-header bg-dark" id="seoAccordian">
                            <h5 class="m-0">
                                <a class="custom-accordion-title text-white" data-bs-toggle="collapse" href="#collapseseo"
                                    aria-expanded="true" aria-controls="collapseseo">
                                    SEO Settings<i class="mdi mdi-chevron-down accordion-arrow"></i>
                                    <p class="text-muted help-text">Add a title and description to see how this category
                                        might appear in a search engine listing</p>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseseo" class="collapse show" aria-labelledby="seoAccordian"
                            data-parent="#custom-accordion-seo">
                            <div class="card-body">
                                <div class="col-md-12 mb-2 {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title') }}">
                                    @error('meta_title')
                                        <span id="meta_title-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2 {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="meta_description">Meta Description</label>
                                    <textarea id="meta_description" class="form-control" name="meta_description" rows="4">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <span id="meta_description-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2 {{ $errors->has('meta_keywords') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ old('meta_keywords') }}">
                                    @error('meta_keywords')
                                        <span id="meta_keywords-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card accordion custom-accordion">
                        <div class="card-header bg-dark" id="imageAccordian">
                            <h5 class="m-0">
                                <a class="custom-accordion-title text-white" data-bs-toggle="collapse"
                                    href="#collapseImage" aria-expanded="true" aria-controls="collapseImage">
                                    Page Banner<i class="mdi mdi-chevron-down accordion-arrow"></i>
                                    <p class="text-muted help-text">Add Banner for Page.</p>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseImage" class="collapse show" aria-labelledby="imageAccordian"
                            data-parent="#custom-accordion-banner">
                            <div id="collapseBanner" class="collapse show" aria-labelledby="bannerAccordian"
                                data-parent="#custom-accordion-banner" style="">
                                <div class="card-body">
                                    <div class="col-md-12 mb-2 {{ $errors->has('banner') ? 'has-error' : '' }}">
                                        <label for="banner">Banner <strong><small>(Size: 1920 X 400
                                                    pixel)</small></strong></label>
                                        <input type="file" class="form-control" id="banner" name="banner"
                                            onchange="loadBanner(this);">
                                        <img id="banner_img"
                                            src="https://via.placeholder.com/1920x400.png?text=Banner+Size+:+1920+x+400+px"
                                            class="mt-2 img-fluid">
                                        @error('banner')
                                            <span id="banner-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-success" form="pageForm"><i
                                class="mdi mdi-database me-1"></i>Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
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
        function loadBanner(input, id) {
            id = id || '#banner_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width('100%')
                        .height('100%');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        function loadThumbnail(input, id) {
            id = id || '#thumbnail_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(150)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
