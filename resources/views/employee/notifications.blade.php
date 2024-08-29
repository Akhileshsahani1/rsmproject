@extends('layouts.employee')
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

                                    @if( $n->type == 'App\Notifications\Employee\JobStatus')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) ) bg-grey  @endif">
                                            Applied <a href="{{ route('frontend.job.show', $n->data['job_id']) }}"> job({{$n->data['job_id']}}) </a> has been {{ $n->data['status'] }}

                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endif

                                    @if( $n->type == 'App\Notifications\Employee\DocRequest')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) ) bg-grey  @endif">
                                        Document request is received for <a href="{{ route('employee.applied-jobs') }}"> job({{$n->data['job_id']}}) </a>

                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>

                                    @endif

                                    @if( $n->type == 'App\Notifications\Employee\NewJobPostingNotification')
                                    <tr>
                                        <td class="@if( is_null($n->read_at) ) bg-grey  @endif">
                                        New <a href="{{ route('frontend.job.show', $n->data['job_id']) }}"> Job ({{$n->data['job_id']}})</a> has posted based on your skills.

                                            <small class="text-muted text-right" style="float:right">{{ $n->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>

                                    @endif


                                    @endforeach
                                    @else
                                    <p class="text-center"> No notification found.</p>
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
                var url = '{{ route("employee.notifications.read",["from" => "page"]) }}';
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
                var url = '{{ route("employee.notifications.delete") }}';
                window.location.href = url;
               }
            })
        }
    </script>
@endpush
