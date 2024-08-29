@extends('layouts.admin')
@section('title', 'Show Admin')

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
                    <h4 class="page-title">Show Admin</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <!-- end page title -->

    </div> <!-- container -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $admin->avatar }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                    <h4 class="mb-0 mt-2">{{ $admin->firstname }} {{ $admin->lastname }}</h4>
                    <p class="text-muted font-14">Admin</p>

                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-success btn-sm mb-2"><i class="fa fa-edit me-1"></i> Edit</a>
                    <a href="javascript:void(0);" onclick="confirmDelete({{ $admin->id }})" class="btn btn-danger btn-sm mb-2"><i class="fa fa-trash-alt me-1"></i> Delete</a>
                    <form id='delete-form{{ $admin->id }}'
                        action='{{ route('admin.admins.destroy', $admin->id) }}'
                        method='POST'>
                        <input type='hidden' name='_token'
                            value='{{ csrf_token() }}'>
                        <input type='hidden' name='_method' value='DELETE'>
                    </form>
                    <p class="text-muted font-14">Date Joined : {{ \Carbon\Carbon::parse($admin->created_at)->format('l, M d h:i A') }}</p>
                    <div class="text-start mt-3">
                        <ul class="list-group list-unstyled">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Fullname</div>
                                </div>
                                <span>{{ $admin->firstname }} {{ $admin->lastname }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Gender</div>
                                </div>
                                <span>{{ $admin->gender }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Email</div>
                                </div>
                                <span>{{ $admin->email }}</span>
                            </li>                            
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Contact Number</div>
                                </div>
                                <span>{{ $admin->phone }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Address</div>
                                </div>
                                <span>{{ $admin->address }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">City</div>
                                </div>
                                <span>{{ $admin->city }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">State</div>
                                </div>
                                <span>{{ $admin->state }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Country</div>
                                </div>
                                <span>{{ $admin->country }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Zipcode</div>
                                </div>
                                <span>{{ $admin->zipcode }}</span>
                            </li>
                        </ul>                      
                    </div>                    
                </div>
            </div>
        </div>
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
