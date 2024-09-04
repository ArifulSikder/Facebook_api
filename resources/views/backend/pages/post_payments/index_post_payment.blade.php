@extends('backend.layouts.master')
@section('title', 'Transfer Funds')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header bg-white">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <p class="manu-name">@yield('title')</p>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="{{ url('transfer_funds') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Transfer Funds</a>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
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
                                                <th>From Account</th>
                                                <th>To Account</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Notes</th>
                                                <th>Actions</th>
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
    </div>
    @push('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('post-payments/data') }}",
                "columns": [
                    { "data": "from_account.name" },  
                    { "data": "to_account.name" },  
                    { "data": "date" },           
                    { "data": "amount" },         
                    { "data": "notes" },            
                    { "data": "actions", "orderable": false, "searchable": false } // Actions
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
