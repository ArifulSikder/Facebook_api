@extends('backend.layouts.master')
@section('title', 'Accounts')
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
                            @can('Add Account')
                            <a href="{{ url('add-account') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Account</a>
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
                                                <th style="width: 15%">Name</th>
                                                <th style="width: 15%">Starting Balance</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
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
                    "ajax": "{{ url('accounts/data') }}", // URL to load data via AJAX
                    "columns": [ {
                            "data": "name"
                        },
                        {
                            "data": "starting_balance"
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
