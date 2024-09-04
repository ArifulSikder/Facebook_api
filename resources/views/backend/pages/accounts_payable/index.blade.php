@extends('backend.layouts.master')
@section('title', 'Payment / Withdrawal')
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
                            @can('Add Payment')
                            <a href="{{ url('add-payment-withdrawal') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Payment /
                                Withdrawal</a>
                            @endcan
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
                                                <th>Payment To</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>From Account</th>
                                                <th>Check #</th>
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
                "ajax": "{{ url('payments/data') }}",
                "columns": [
                    { "data": "payable_to" },  // Payable to (user's name)
                    { "data": "date" },             // Date of payment
                    { "data": "amount" },           // Amount of payment
                    { "data": "type.payment_type_name" }, // Payment type
                    { "data": "from_account.name" }, // Account name
                    { "data": "check_number" },     // Check number
                    { "data": "notes" },            // Notes related to the payment
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
