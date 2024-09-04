@extends('backend.layouts.master')
@section('title', 'Members')
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
                            @can('Add Member')
                            <a href="{{ url('add-member') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Member</a>
                            @endcan
                            {{--  <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>  --}}
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <hr>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table payment-table table-borderless" id="datatable">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Member ID</th>
                                                <th style="width: 15%">Name</th>
                                                <th style="width: 15%">Address</th>
                                                <th style="width: 10%">Birthday</th>
                                                <th style="width: 10%">Phone</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        {{--  <tbody>
                                            @foreach ($members as $member)
                                            <tr>
                                                <td>{{ $member->getMemberId() }}</td>
                                                <td><a href="{{ url('members/payment-log/'. $member->getMemberId()) }}">{{ $member->name }}</a></td>
                                                <td>{{ $member->address }}</td>
                                                <td>{{ $member->birthday }}</td>
                                                <td>{{ $member->phone }}</td>
                                                <td>
                                                    <a href="{{ url("edit-member/".$member->id) }}" class="p-2"><i class="fas fa-edit fa-lg text-primary"></i></a>
                                                    <a id="delete" href="{{ url("delete-member/".$member->id) }}" class="p-2"><i class="fas fa-trash fa-lg text-danger"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>  --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    "processing": true, // Show processing indicator
                    "serverSide": true, // Enable server-side processing
                    "ajax": "{{ url('members/data') }}", // URL to load data via AJAX
                    "columns": [{
                            "data": "member_id"
                        }, // Matches the keys returned by the AJAX response
                        {
                            "data": "name"
                        },
                        {
                            "data": "address"
                        },
                        {
                            "data": "birthday"
                        },
                        {
                            "data": "phone"
                        },
                        {
                            "data": "actions",
                            "orderable": false,
                            "searchable": false
                        } // Disable ordering and searching on action buttons
                    ],
                    "paging": true,
                    "pageLength": 10,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>
    @endpush
@endsection
