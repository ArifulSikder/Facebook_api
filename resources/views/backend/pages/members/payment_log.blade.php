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
                        <a href="{{ url('add-member') }}" class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Member</a>
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
                <div id="overviewCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        @foreach ($accounts->chunk(4) as $index => $chunk)
                            <div class="carousel-item @if ($index == 0) active @endif">
                                <div class="row">
                                    @foreach ($chunk as $account)
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-light">
                                                <a href="#">
                                                    <div class="inner p-2">
                                                        <p>{{ $account->name }}</p>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                ${{ number_format(calculateTotalBalanceForMember($account, $member->id), 2, '.', ',') }}
                                                            </div>
                                                            <div class="col-md-6">Balance</div>
                                                            <div class="col-md-6">${{ member_earning_YTD($account, $member->id) }}
                                                            </div>
                                                            <div class="col-md-6">YTD</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#overviewCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#overviewCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>


                <form id="filterForm" action="{{ url('members/payment-log/' . $member->getMemberId()) }}">
                    <div class="row my-4">
                        <h3 class="col-md-4" style="font-weight: bold;">{{ $member->name }}&nbsp;&nbsp; <span
                                id="amount">${{  number_format($earnings->sum('amount'), 2, '.', ',') }}</span></h3>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="account" id="account_id" style="width: 100%">
                                    <option value="" selected="selected">Select Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Date range -->
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control float-right" name="from_and_to_date"
                                        id="reservation"  value="{{ request('from_and_to_date') ? request('from_and_to_date') : "" }}">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table payment-table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Member ID</th>
                                                <th>Date</th>
                                                <th>Offering</th>
                                                <th>Account</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($earnings as $earning)
                                                <tr>
                                                    <td>{{ $earning->member->getMemberId() }}</td>
                                                    <td>{{ formatedDate($earning->date) }}</td>
                                                    <td>${{ number_format($earning->amount, 2, '.', ',') }}</td>
                                                    <td>{{ $earning->account->name }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>


                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@push('js')
<script>
    $(document).ready(function() {
        // Trigger form submission when account is changed
        $('#account_id').on('change', function() {
            $('#filterForm').submit();
        });

        // Trigger form submission when date range is changed
    
        // Trigger form submission when date range is applied
        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
            // Format and set the value of the input field
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            // Submit the form
            $('#filterForm').submit();
        });

        // Optional: Reset input value and submit form when date range picker is canceled
        $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val(''); // or use a default value like 'From date to date'
            $('#filterForm').submit();
        });
    });
</script>
@endpush
@endsection
