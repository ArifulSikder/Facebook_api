@extends('backend.layouts.master')
@section('title', 'Earnings List')
@section('content')
    <div class="content-wrapper">
        <div class="content-header bg-white">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <p class="manu-name">@yield('title')</p>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="{{ url('add-new-post-offering') }}"
                               class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add New Post Offering</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <hr>
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table payment-table table-borderless" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Member</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Check Number</th>
                                                <th>Payment Type</th>
                                                <th>Account</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('earnings/data') }}",
                    "columns": [
                        { "data": "member_name" },
                        { "data": "date" },
                        { "data": "amount" },
                        { "data": "payment_type" },
                        { "data": "check_number" },
                        { "data": "account_name" },
                        { "data": "actions", "orderable": false, "searchable": false }
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
