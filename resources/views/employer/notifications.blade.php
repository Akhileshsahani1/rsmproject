@extends('layouts.employer')
@section('title', 'Notifications')
@section('content')
<h5 class="page-title">Notifications</h5>
    <div class="card">
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">

                            @if( count($notifications) > 0 )

                                <button class="btn btn-danger mb-2" onclick="clearAll()" style="float:left">Clear All</button>
                                <button class="btn btn-success mb-2" onclick="MarkAll()" style="float:right">Mark Read All</button>

                                <form id="clear-form" action="{{ '' }}" method="post">
                                    @csrf()
                                </form>

                                <tbody>


                                    @foreach( $notifications as $n )

                                    @if( $n->type == 'App\Notifications\Employer\NewApplication')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) ) bg-grey  @endif">
                                            New <a href="{{ route('job.applicants', $n->data['job_id']) }}"> job({{$n->data['job_id']}}) </a> application received from
                                             {{ $n->data['name'] }}

                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endif

                                    @if( $n->type == 'App\Notifications\Employer\DocRequest')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) )bg-grey @endif">
                                            Document requested from {{ $n->data['name'] }}
                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endif

                                    @if( $n->type == 'App\Notifications\Employer\DocRespond')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) )bg-grey @endif">
                                            Document {{ $n->data['status'] }} from {{ $n->data['name'] }}
                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endif

                                    @if( $n->type == 'App\Notifications\Employer\JobStatus')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) )bg-grey @endif">
                                            Job  assigned to  {{ $n->data['name'] }}  is {{ $n->data['status'] }}
                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endif

                                    @if( $n->type == 'App\Notifications\Employer\JobClosed')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) )bg-grey @endif">
                                        The listed <a href="{{ route('closed-job') }}">Job({{$n->data['job_id']}})</a> has been closed.
                                    </td>
                                    </tr>
                                    @endif

                                    @if( $n->type == 'App\Notifications\Employer\ApprovalNotification')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) )bg-grey @endif">
                                        Your <a href="{{ route('open-jobs') }}">Job({{$n->data['job_id']}})</a> has been approved.
                                    </td>
                                    </tr>
                                    @endif

                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="bg-grey"> No notification found.</td>
                                    </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function MarkAll() {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to mark all read !",
                icon: "info",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("notifications.read",["from" => "page"]) }}';
                window.location.href = url;
                setTimeout(()=>{ window.location.reload(true); },1000);
               }
            })
        }

        function clearAll() {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete all notifications !",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes delete it"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("notifications.delete") }}';
                window.location.href = url;
               }
            })
        }
    </script>
@endpush
