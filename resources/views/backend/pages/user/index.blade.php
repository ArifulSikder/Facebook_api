@extends('backend.admin_layouts.admin-master')

@section('users', 'menu-open')
@section('users_active', 'active rounded-pill')
@section('users_list', 'active rounded-pill')

@section('title')
    Users List
@endsection
@section('maincontant')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb ">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 my-2">
                    <button type="button" data-toggle="modal" data-target="#registerUser"
                        class="btn btn-success  rounded-pill"><i class="fas fa-plus"></i> Register
                        User
                    </button>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-gray text-bold">
                            Users List
                        </div>
                        <table class="table align-middle mb-0 bg-white table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $serial = ($users->currentpage() - 1) * $users->perpage() + 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{ $serial++ }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ URL::asset($user->photo) }}" alt="{{ $user->photo }}"
                                                    style="width: 45px; height: 45px" class="rounded-circle" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3">
                                                    <p class="fw-bold mb-1">{{ $user->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="fw-normal mb-1">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-success rounded-pill d-inline">
                                                {{ getUserType($user->id) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" data-toggle="modal"
                                                data-target="#editUser{{ $user->id }}"
                                                class="btn btn-primary btn-sm rounded-pill btn-rounded text-light">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </button>
                                            <a href="{{ url('delete-user/' . $user->id) }}" id="delete" type="button"
                                                class="btn btn-danger btn-sm rounded-pill btn-rounded text-light">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    @include('backend.user.editUser')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @include('backend.user.registerUser')

        </div>
    </section>
@endsection

@section('script')
    <script>
        //password chacker
        $(document).ready(function() {
            $('#password').keyup(function() {
                value = $(this).val();
                if (value.length < 8) {
                    $('#password_alert').html('Please Enter Minimum 8 Digit!');
                } else if (value.length >= 8) {
                    $('#password_alert').empty();
                };
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            //edit modal close restart
            $(".editUser").on("hidden.bs.modal", function() {
                $(this).find('form').trigger('reset');
            });
            //add modal reset
            $('#registerUser').on("hidden.bs.modal", function() {
                $('#name').val('');
                $('#email').val('');
                $('#photoUpload').val('');
                $('#user_type').val('');
                $('.previewHolder').attr('src', '');

            });

            //preview image user
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.previewHolder').attr('src', '');
                        $('.previewHolder').attr('src', e.target.result);
                        $('.previewHolder').css('width', '100px')
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('select a file to see preview');
                    $('.previewHolder').attr('src', '');
                }
            }
            $("#photoUpload").change(function() {
                readURL(this);
            });

            //preview image user
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.previewUpdate').attr('src', '');
                        $('.previewUpdate').attr('src', e.target.result);
                        $('.previewUpdate').css('width', '100px')
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert('select a file to see preview');
                    $('.previewUpdate').attr('src', '');
                }
            }
            $(".photoUpdate").change(function() {
                readURL(this);
            });
        });
    </script>
@endsection
