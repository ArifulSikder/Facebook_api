@extends('backend.layouts.master')
@section('title', 'Dashboard')
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

                            {{--  <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>  --}}
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <hr>
        <!-- /.content-header -->
        <!-- Main content -->
        @can('Dashboard')
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
                                                                    @php

                                                                        $staringBalanceAmount = isset($startingBalance)
                                                                            ? $startingBalance->amount
                                                                            : $account->startingBalance->amount;
                                                                    @endphp
                                                                    ${{ number_format(calculateTotalBalance($account, $staringBalanceAmount), 2) }}
                                                                </div>
                                                                <div class="col-md-6">Balance</div>
                                                                <div class="col-md-6">${{ earning_YTD($account) }}
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


                    <form id="filterForm" action="{{ url('dashboard') }}">
                        <div class="row my-4">
                            @if ($transactions->isNotEmpty())
                                <h3 class="col-md-4" style="font-weight: bold;">
                                    @php
                                        $firstSelectAccount = $transactions->first()->account;
                                        $payment = $transactions
                                            ->where('account_id', $firstSelectAccount->id)
                                            ->where('payment_id', '!=', null)
                                            ->sum('amount');
                                        $transfer_out = $transactions
                                            ->where('account_id', $firstSelectAccount->id)
                                            ->where('tranfer_id', '!=', null)
                                            ->where('transaction_status', 4)
                                            ->sum('amount');
                                        $totalAmount = $transactions
                                            ->where('account_id', $firstSelectAccount->id)
                                            ->where('payment_id', '=', null)
                                            ->where('tranfer_id', '=', null)
                                            ->sum('amount');

                                        $existingTransactions =
                                            intval($totalAmount) - intval($payment) - intval($transfer_out);

                                    @endphp
                                    {{ $firstSelectAccount->name }}&nbsp;&nbsp;
                                    <span id="amount">
                                        ${{ number_format($existingTransactions, 2) ?? 0 }}
                                    </span>
                                </h3>
                            @else
                                <h3 class="col-md-4" style="font-weight: bold;">
                                    No earnings available
                                    <span id="amount">$0</span>
                                </h3>
                            @endif


                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control select2bs4" name="account" id="account_id" style="width: 100%">
                                        <option value="" selected="selected">Select Account</option>
                                        @foreach ($accounts as $index => $account)
                                            <option value="{{ $account->id }}"
                                                {{ request('account') == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Date range -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control float-right" name="from_and_to_date"
                                            id="reservation"
                                            value="{{ request('from_and_to_date') ? request('from_and_to_date') : '' }}">
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
                                                @foreach ($transactions as $transection)
                                                    <tr>
                                                        <td>
                                                            @if (!empty($transection->starting_balance_id))
                                                                Staring Balance
                                                            @elseif (!empty($transection->post_offering_id))
                                                            @php
                                                            $admin = Auth::user()->getRoleNames()->contains('Admin');
                                                            $member = encriptMemberId($transection->member_id);
                                                            if ($admin) {
                                                                $member = \App\Models\User::find($transection->member_id)->name;
                                                            }
                                                        @endphp
                                                        <span data-toggle="tooltip" data-placement="top" title="{{ $member }}">{{ encriptMemberId($transection->member_id) }}</span>
                                                        
                                                            @elseif (!empty($transection->payment_id))
                                                                Payment
                                                            @elseif (!empty($transection->tranfer_id) && $transection->transaction_status == 3)
                                                                Traster In
                                                            @elseif (!empty($transection->tranfer_id) && $transection->transaction_status == 4)
                                                                Traster Out
                                                            @else
                                                            @endif
                                                        </td>
                                                        <td>{{ formatedDate($transection->date) }}</td>
                                                        <td>
                                                            @if (!empty($transection->tranfer_id) && $transection->transaction_status == 3)
                                                            <span class="text-success">&nbsp;</span>
                                                                ${{ number_format($transection->amount, 2) }}
                                                            @elseif (!empty($transection->tranfer_id) && $transection->transaction_status == 4)
                                                                <span class="text-danger">-</span>
                                                                ${{ number_format($transection->amount, 2) }}
                                                            @else
                                                                <span class="text-success">&nbsp;&nbsp;</span>${{ number_format($transection->amount, 2) }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $transection->account->name }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right">
                                        {{ $transactions->links() }}
                                    </div>
                                </div>
                            </div>
                        </section>


                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        @endcan
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('#account_id').on('change', function() {
                    $('#filterForm').submit();
                });
                $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                        'MM/DD/YYYY'));
                    $('#filterForm').submit();
                });

                $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val(''); // or use a default value like 'From date to date'
                    $('#filterForm').submit();
                });
            });
        </script>
    @endpush
@endsection
