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
                            <a href="{{ url('add-payment-withdrawal') }}"
                            class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Payment / Withdrawal</a>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <hr>
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <form action="{{ route('store-payment-withdrawal') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="payable_to">Payment To</label>
                                                <input type="text" name="payable_to" id="payable_to" required=""
                                                    class="form-control col-md-8" placeholder="Enter Payment To"
                                                    value="{{ old('payable_to') }}">
                                            </div>
                                            @error('payable_to')
                                                <div class="text-danger offset-3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 pl-2">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2">Date</label>
                                                <div class="input-group date col-md-8" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="date"
                                                        class="form-control datetimepicker-input"
                                                        data-target="#reservationdate" placeholder="Enter date"
                                                        data-toggle="datetimepicker" value="{{ old('date') }}" />
                                                </div>
                                                @error('date')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rowContainer">
                                        <div class="row offering-row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="from_account">From Account</label>
                                                    <select class="form-control select2bs4 col-md-8" name="from_account"
                                                        id="from_account" required>
                                                        <option value="" selected="selected">Select Account</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}" {{ old('from_account') == $account->id ? 'selected' : '' }}>{{ $account->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('account')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="amount">Amount</label>
                                                    <input type="number" name="amount" id="amount" required=""
                                                        class="form-control col-md-8" placeholder="Enter amount"
                                                        value="{{ old('amount') }}">
                                                </div>
                                                @error('amount')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="type">Type</label>
                                                    <select class="form-control select2bs4 col-md-8" name="type"
                                                        id="type" required>
                                                        <option value="" selected="selected">Select Account</option>
                                                        @foreach ($payment_types as $type)
                                                            <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>
                                                                {{ $type->payment_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('type')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 d-none" id="check_row">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="check_number">Check Number</label>
                                                    <input type="text" name="check_number" id="check_number"
                                                        class="form-control col-md-8" placeholder="Enter Check Number"
                                                        value="{{ old('check_number') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="notes">Notes</label>
                                                    <textarea class="form-control col-md-8" type="text" name="notes" id="notes"
                                                        class="form-control" placeholder="Enter Notes" value="">{{ old('notes') }}</textarea>
                                                </div>
                                                @error('notes')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="footer mr-4 pr-3">
                                        <div class="float-right">
                                            <button class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('js')
        <script>
            $(document).ready(function(){
            
                $("#type").on('change', function(e) {
                    e.preventDefault();
                    var type_id = $(this).val();
                    if (type_id == 1 || type_id == '') {
                        $("#check_row").removeClass('d-block').addClass('d-none');
                    } else if (type_id == 2) {
                        $("#check_row").removeClass('d-none').addClass('d-block');
                    }
                });

                $("#amount").keyup(function(e) {
                    // No need to call e.preventDefault() for keyup event
                    var $amountInput = $(this); // Store the reference to the #amount input
                    var amount = $amountInput.val();
                    var account_id = $("#from_account").val();
                
                    $.ajax({
                        type: "GET",
                        url: "{{ url('amount-check-from-account') }}", // Ensure this URL is correct
                        data: {
                            account_id: account_id
                        },
                        success: function(data) {
                            console.log(data.available_balance);
                            if (data.available_balance < amount) {
                                $amountInput.val(''); // Use the stored reference
                                toastr.error('Insufficient Balance'); 
                            }
                        }
                    });
                });
                
            })
        </script>
    @endpush
@endsection
