@extends('layouts.admin')
@section('title', 'Notifications')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">                        
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger float-end me-1" style="display: none"
                            id="delete-all">
                            <i class="mdi mdi-delete"></i> {{ __('Delete') }}</a>
                    </div>
                    <h4 class="page-title">Notifications</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        @include('admin.notifications.filter')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                @if(count($notifications) > 0)
                                <ul class="list-group">
                                    @foreach ($notifications as $notification)
                                        <li class="list-group-item align-items-center">
                                            {!! $notification->message !!}
                                            <br>
                                            <span class="text-muted"><small><i class="mdi mdi-clock-outline me-1"></i>{{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}</small></span>                                            
                                        </li>
                                    @endforeach
                                </ul>                               
                                {{ $notifications->appends(request()->query())->links('pagination::bootstrap-5') }}
                                @else
                                    <h4 class="text-center py-5"><i class="mdi mdi-bell me-1"></i>No Notification found</h4>
                                @endif
                            </div>
                        </div>
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
