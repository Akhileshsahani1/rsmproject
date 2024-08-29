@extends('layouts.admin')
@section('title', 'Skills')
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
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-skill-modal">Add</button>

                    </div>
                    <h4 class="page-title">Skills</h4>
                </div>
            </div>
        </div>
        @include('admin.includes.flash-message')
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                    <thead class="bg-dark">
                                        <tr>
                                            <th style="width: 50%;">Skill</th>
                                            <th>Status</th>
                                             <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skills as $skill)
                                            <tr>
                                                <td>
                                                   {{ $skill->name }}
                                                </td>
                                                <td >
                                                    <input type="checkbox" id="switch{{$skill->id}}" @if($skill->status) checked @endif data-switch="success" onchange="changeStatus('{{ $skill->id }}')" />
                                                    <label for="switch{{$skill->id}}" data-on-label="Yes" data-off-label="No"></label>
                                                </td>
                                                <td class="text-end">
                                                    <a href="javascript:void(0);"
                                                            onclick="editSkill('{{$skill->id}}','{{ $skill->name }}')"
                                                            class="btn btn-primary" ><i class="fa fa-edit me-1"></i>
                                                            Edit
                                                            </a>
                                                    <a href="javascript:void(0);"
                                                            onclick="confirmDelete({{ $skill->id }})"
                                                            class="btn btn-danger"><i class="fa fa-trash-alt me-1"></i>
                                                            Delete
                                                            </a>
                                                        <form id='delete-form{{ $skill->id }}'
                                                            action='{{ route('admin.skills.destroy', $skill->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="add-skill-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mt-2 mb-4">
                        <h3> Skill </h3>
                    </div>

                    <form method="POST" action="{{ route('admin.skills.store') }}" class="ps-3 pe-3" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="0" name="skill_id" id="skill-id">
                        <div class="mb-3">
                            <label for="add-skill" class="form-label">Skill</label>
                            <input name="skill" class="form-control" type="text" id="add-skill" required="" placeholder="Skill">
                        </div>
                        <div class="mb-3 text-center">
                            <button class="btn btn-rounded btn-primary" type="submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
                    orderable: !0
                }, {
                    orderable: !0
                }]
            })
        });
    </script>
    <script type="text/javascript">
        function changeStatus(id){
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                }
            });
            var formData = {
                skill_id: id,
            };
            let url = "{{ route('admin.skills.edit',':id') }}";

            $.ajax({
                type: 'GET',
                url: url.replace(':id',id),
                data: formData,
                dataType: 'json',
                beforeSend: function() {

                },
                success: function(res, status) {

                },
                error: function(res, status) {

                }
            });
        }
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

        function editSkill(id,skill){
           $('#skill-id').val(id);
           $('#add-skill').val(skill);
           $('#add-skill-modal').modal('show');
        }
    </script>
@endpush
