@extends('layouts.admin')
@section('title', 'Show Employer')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark me-1"><i
                                class="mdi mdi-chevron-double-left me-1"></i>Back</a>
                    </div>
                    <h4 class="page-title">Show Employer</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

     <!-- container -->
    <section class="view_applicant">
        <div class="card">
            <div class="card-header">
                <div class="thumb-image">
                    <img src="{{ $employer->avatar }}" class="avatar-lg img-thumbnail" alt="profile-image">
                </div>
                <div class="edit-companany">
                    @if ($employer->status == false)
                        <a href="{{ route('admin.employers.approval-form', $employer->id) }}"
                            class="btn btn-warning btn-sm mb-2"><i class="fa fa-check me-1"></i>Approve</a>
                    @endif
                    <a href="{{ route('admin.employers.edit', $employer->id) }}" class="btn btn-success btn-sm mb-2"><i
                            class="fa fa-edit me-1"></i> Edit</a>
                    <a href="javascript:void(0);" onclick="confirmDelete({{ $employer->id }})"
                        class="btn btn-danger btn-sm mb-2"><i class="fa fa-trash-alt me-1"></i> Delete</a>
                    <form id='delete-form{{ $employer->id }}' action='{{ route('admin.employers.destroy', $employer->id) }}'
                        method='POST'>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                        <input type='hidden' name='_method' value='DELETE'>
                    </form>
                    <p>Date Joined : {{ \Carbon\Carbon::parse($employer->created_at)->format('l, M d h:i A') }}</p>
                </div>

            </div>
            <div class="card-body">
                <h4 class="jobtitle">{{ $employer->owner_name }}</h4>
                <span class="companyname">{{ __('Employer') }}</span>
            </div>
        </div>
    </section>
    <section class="appliant_details mb-5">
        <div class="card-body">
            <div class="JobDetails">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mt-2">
                            <label><strong>Company Name</strong></label>
                            <p>{{ $employer->company_name }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Fullname</strong></label>
                            <p>{{ $employer->owner_name }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Email</strong></label>
                            <p>{{ $employer->email }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Email (Additional)</strong></label>
                            <p>{{ $employer->email_additional }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Contact Number</strong></label>
                            <p>{{ $employer->phone }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Website</strong></label>
                            <p>{{ $employer->website }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mt-2">
                            <label><strong>Address</strong></label>
                            <p>{{ $employer->address }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>City</strong></label>
                            <p>{{ $employer->city }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>State</strong></label>
                            <p>{{ $employer->state }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Country</strong></label>
                            <p>{{ $employer->country }}</p>
                        </div>
                        <div class="form-group mt-2">
                            <label><strong>Zipcode</strong></label>
                            <p>{{ $employer->zipcode }}</p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group mt-2">
                            <label><strong>Description</strong></label>
                            <p>{{ $employer->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && document.getElementById("delete-form" + e).submit()
            })
        }
    </script>
@endpush
