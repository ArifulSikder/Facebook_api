@extends('backend.layouts.master')

@section('title')
    Permission
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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Permissions List (Drag and Dropable)</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Serial</th>
                                            <th>Permission Name</th>
                                            <th style="width: 30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableData">
                                        @php
                                            if (method_exists($permissions, 'links')) {
                                                $serial =
                                                    ($permissions->currentpage() - 1) * $permissions->perpage() + 1;
                                            } else {
                                                $serial = 1;
                                            }
                                        @endphp
                                        @foreach ($permissions as $permission)
                                            <tr class="rowSort" id="{{ $permission->id }}">
                                                <td>{{ $serial++ }}</td>
                                                <td>
                                                    @if ($permission->parent)
                                                        @include(
                                                            'backend.pages.user.role_and_permission.childreen',
                                                            [
                                                                'parent' => $permission->parent,
                                                            ]
                                                        )
                                                    @endif
                                                    <span class="text-success">{{ $permission->name }}</span>
                                                </td>
                                        
                                                <td>
                                                    <button
                                                        class="btn btn-primary btn-sm rounded-pill btn-rounded text-light editModal"
                                                        data-toggle="modal" data-target=".editForm"
                                                        data-name="{{ $permission->name }}"
                                                        data-id="{{ $permission->id }}"
                                                        data-parent_id="{{ $permission->parent === null ? '' : $permission->parent->id }}"><i
                                                            class="fas fa-edit"></i>
                                                        Edit</button>
                                                    {{--  <a href="{{ url('role-permission-list/' . $permission->id) }}"
                                                        class="btn btn-info btn-sm rounded-pill btn-rounded text-light">Show
                                                        Permission</a>  --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    @if (method_exists($permissions, 'links'))
                                        {{ $permissions->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Permission</h3>
                            </div>
                            <div class="card-body">
                                <!-- form start -->
                                <form role="form" action="{{ route('create-permission') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="parent_id">Parent (If Has Patent)</label>
                                            <select type="text"
                                                class="form-control select2 @error('parent_id') is-invalid @enderror"
                                                name="parent_id" data-placeholder="Choose Parent Permission">
                                                <option selected></option>
                                                @foreach ($permission_data as $data)
                                                    <option value="{{ $data->id }}">

                                                        @if ($data->parent)
                                                            @include(
                                                                'backend.pages.user.role_and_permission.childreen_dropdown',
                                                                ['parent' => $data->parent]
                                                            )
                                                        @endif
                                                        <span class="text-success">{{ $data->name }} </span>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" placeholder="Enter Permission Name">
                                        </div>

                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
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
                    <div class="modal fade editForm">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Permission</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- form start -->
                                <form id="EditForm">
                                    <div class="card-body">
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group">
                                            <label for="parentId">Parent (If Has Patent)</label>
                                            <select type="text"
                                                class="form-control select2 @error('parent_id') is-invalid @enderror"
                                                name="parent_id" id="parentId" data-placeholder="Choose Parent Permission">
                                                <option selected></option>
                                                @foreach ($permission_data as $data)
                                                    <option value="{{ $data->id }}">
                                                        @if ($data->parent)
                                                            @include(
                                                                'backend.pages.user.role_and_permission.childreen_dropdown',
                                                                ['parent' => $data->parent]
                                                            )
                                                        @endif
                                                        <span class="text-success">{{ $data->name }} </span>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="permissionName">Name</label>
                                            <input type="text" id="permissionName"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                placeholder="Enter Permission Name">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger rounded-pill btn-rounded"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit"
                                            class="btn btn-primary rounded-pill btn-rounded">Submit</button>
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
                    //validation name clear
                    $('#validationName').text('');
                    $('#validationName').text('');

                    //fill the role form
                    $('#id').val($(this).data('id'));
                    $('#permissionName').val($(this).data('name'));
                    $('#parentId').val($(this).data('parent_id')).trigger('change');
                });


                //update ajax request
                $("#EditForm").on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData($("#EditForm")[0]);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('update-permission') }}",
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
                            $('#validationName').text('');
                            $('#validationUrl').text('');
                            $.each(error.responseJSON.errors, function(field_name, error) {
                                if (field_name == 'name') {
                                    $('#validationName').text(error);
                                    toastr.error(error)
                                } else {
                                    $('#validationUrl').text(error);
                                    toastr.error(error)
                                }
                            });
                        },
                        complete: function(done) {
                            if (done.status == 200) {
                                window.location.reload();
                            }
                        }
                    });
                });
            });
            $("#tableData").sortable({
                items: 'tr:not(.bg-dark)',
                curser: 'move',
                opacity: 0.60,
                update: function() {
                    sortingFunction();
                    viewData();
                }
            });

            function sortingFunction() {
                var order = [];
                $("tr.rowSort").each(function(index, value) {
                    order.push({
                        id: $(this).attr('id'),
                        position: index + 1,
                    });
                })
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    datatype: 'json',
                    url: "{{ url('sort-permission-data') }}",
                    data: {
                        order: order
                    },
                    success: function(data) {

                    },
                    error: function(error) {

                    }
                })
            }
        </script>
    @endpush
@endsection
