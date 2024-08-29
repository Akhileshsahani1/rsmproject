@extends('layouts.admin')
@if (request()->get('status') == 'approved')
    @section('title', 'Approved Jobs')
@else
    @section('title', 'Pending Jobs')
@endif
@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary float-end"><i
                                class="mdi mdi-plus"></i> Add
                            job</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger float-end me-1" style="display: none"
                            id="delete-all">
                            <i class="mdi mdi-delete"></i> {{ __('Delete') }}</a>
                    </div>
                    <h4 class="page-title">{{ request()->get('status') == 'approved' ? 'Approved' : 'Pending' }} Jobs</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        @include('admin.jobs.filter')
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100"
                                    style="font-size: 14px;">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th class="all" width="3%">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="all-rows">
                                                    <label class="form-check-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Job</th>
                                            <th>Employer</th>
                                            <th>No. of Position</th>
                                            <th>Type</th>
                                            <th>Skills</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobs as $job)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input checkbox-row"
                                                            name="rows" id="customCheck{{ $job->id }}"
                                                            value="{{ $job->id }}">
                                                        <label class="form-check-label"
                                                            for="customCheck{{ $job->id }}">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $job->id }}</td>
                                                <td>{{ $job->position_name }}</td>
                                                <td class="table-user">
                                                    <a href="{{ route('admin.employers.show', $job->employer->id) }}"
                                                        class="text-body fw-semibold">{{ $job->employer->company_name }}</a>
                                                </td>
                                                <td>{{ $job->no_of_position }}</td>
                                                <td>{{ $job->position_type }}</td>
                                                <td>
                                                    @foreach ($job->skills_required as $skill)
                                                    <span class="badge badge-success-lighten p-1">{{ $skill }}</span>
                                                    @if (($loop->index+1)%3 == 0)
                                                       </br>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ ucFirst($job->status) }}</td>
                                                <td class="text-end">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @if ($job->status == 'pending')
                                                            <a href="javascript:void(0)" onclick="approveJob({{ $job->id }})"
                                                                class="dropdown-item"><i class="fa fa-check me-1"></i>
                                                                Approve
                                                                Job</a>
                                                            <div class="dropdown-divider"></div>
                                                        @endif
                                                        <a href="{{ route('admin.jobs.applicants', $job->id) }}"
                                                            class="dropdown-item"><i class="fa fa-eye me-1"></i>
                                                            Show
                                                            Applicants</a>
                                                        <a href="{{ route('admin.jobs.edit', $job->id) }}"
                                                            class="dropdown-item"><i class="fa fa-edit me-1"></i>
                                                            Edit
                                                            Job</a>
                                                        <a href="{{ route('admin.jobs.show', $job->id) }}"
                                                            class="dropdown-item"><i class="fa fa-eye me-1"></i>
                                                            Show
                                                            Job</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="confirmDelete({{ $job->id }})"
                                                            class="dropdown-item"><i class="fa fa-trash-alt me-1"></i>
                                                            Delete
                                                            Job</a>
                                                        <form id='delete-form{{ $job->id }}'
                                                            action='{{ route('admin.jobs.destroy', $job->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $jobs->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>


    <!-- Datatable Init js -->
    <script>
        $(function() {
            $("#basic-datatable").DataTable({
                paging: !1,
                pageLength: 20,
                lengthChange: !1,
                searching: !1,
                ordering: !0,
                info: !1,
                autoWidth: !1,
                responsive: !0,
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: [0],
                    visible: !0,
                    searchable: !0
                }],
                columns: [{
                    orderable: !1
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !1
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                } ]
            })
        });
    </script>

    <script type="text/javascript">
        $("#all-rows").change(function() {
            var c = [];
            this.checked ? ($(".checkbox-row").prop("checked", !0), $("input:checkbox[name=rows]:checked").each(
                function() {
                    c.push($(this).val())
                }), $("#delete-all").css("display", "block")) : ($(".checkbox-row").prop("checked", !1),
                c = [], $("#delete-all").css("display", "none"))
        });

        $(".checkbox-row").change(function() {
            rows = [], $("input:checkbox[name=rows]:checked").each(function() {
                rows.push($(this).val())
            }), 0 == rows.length ? $("#delete-all").css("display", "none") : $("#delete-all").css("display",
                "block")
        });

        $("#delete-all").click(function(e) {
            rows = [], $("input:checkbox[name=rows]:checked").each(function() {
                rows.push($(this).val())
            }), Swal.fire({
                title: "Are you sure?",
                text: "You want to delete selected rows!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete selected!"
            }).then(t => {
                t.isConfirmed && ($("#delete-all").text("Deleting..."), e.preventDefault(), $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.jobs.bulk-delete') }}",
                    data: {
                        jobs: rows,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(e) {
                        location.reload()
                    }
                }))
            })
        });

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

        $(".change-password").click(function() {
            var a = $(this).data("id"),
                t = $(this).data("name");
            $("#id").val(a), $("#volunteer_name").text(t), $("#volunteer_name_input").val(t)
        });

        function approveJob(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Approve Job!"
            }).then(t => {
               if(t.isConfirmed){
                var url = '{{ route("admin.jobs.approval-form", ":id") }}';
                url = url.replace(':id', id);
                window.location.href = url;
               }
            })
        }
    </script>
@endpush
