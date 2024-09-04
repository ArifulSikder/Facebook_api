@extends('backend.layouts.master')
@section('title')
    Role
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header bg-white">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <p class="manu-name">@yield('title')</p>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{--  <a href="{{ url('add-member') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Member</a>  --}}
                            {{--  <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>  --}}
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <hr>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Roles List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Serial</th>
                                            <th>Roles Name</th>
                                            <th style="width: 20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $serial = ($roles->currentpage() - 1) * $roles->perpage() + 1;
                                        @endphp
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $serial++ }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-primary btn-sm rounded-pill btn-rounded text-light editModal"
                                                        data-toggle="modal" data-target="#editRole"
                                                        data-name="{{ $role->name }}" data-id="{{ $role->id }}"><i
                                                            class="fas fa-edit"></i>
                                                        Edit</button>
                                                    {{-- <a href="{{ url('role-permission-list/' . $role->id) }}"
                                            class="btn btn-info btn-sm rounded-pill btn-rounded text-light">Show
                                            Permission</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Role</h3>
                            </div>
                            <div class="card-body">
                                <!-- form start -->
                                <form role="form" action="{{ route('create_role') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" placeholder="Ex: Admin, Moderator...">
                                        </div>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- modal edit --}}
                    <div class="modal fade" id="editRole">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Role</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- form start -->
                                <form id="EditForm">
                                    <div class="modal-body">

                                        <input type="hidden" id="id" name="id" value="{{ $role->id }}">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name" id="roleName"
                                                    placeholder="Ex: Admin, Moderator..." value="{{ $role->name }}">
                                            </div>

                                            <span class="text-danger validationName" role="alert">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('.editModal').click(function(e) {
                    e.preventDefault();
                    $('.validationName').text('');
                    $('#id').val($(this).data('id'));
                    $('#roleName').val($(this).data('name'));
                });


                //update ajax request 
                $("#EditForm").on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData($("#EditForm")[0]);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('updateRole') }}",
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.success)
                            $("#EditForm")[0].reset();
                            $('#editRole').modal('hide');

                        },
                        error: function(error) {
                            $('.validationName').text('');
                            $.each(error.responseJSON.errors, function(field_name, error) {
                                if (field_name == 'name') {
                                    $('.validationName').text(error);
                                    toastr.error(error)
                                }
                            });
                        },
                        complete: function(xhr) {
                            if(xhr.status == 200) {
                                location.reload();
                            }                
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
