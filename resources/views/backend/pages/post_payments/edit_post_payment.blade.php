@extends('backend.layouts.master')
@section('title', 'Edit Transfer Funds')
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
                            <a href="{{ url('transfer-funds') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Transfer Funds</a>
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
                        <form action="{{ route('update-post-payment', ['id' => $payment->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="from_account">From Account</label>
                                                <select class="form-control select2bs4 col-md-8" name="from_account"
                                                    id="from_account">
                                                    <option value="" selected="selected">Select from account</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            {{ $payment->from_account == $account->id ? 'selected' : '' }}>
                                                            {{ $account->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="to_account">To Account</label>
                                                <select class="form-control select2bs4 col-md-6" name="to_account"
                                                    id="to_account" required>
                                                    <option value="" selected="selected">Select Account</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            {{ $payment->to_account == $account->id ? 'selected' : '' }}>
                                                            {{ $account->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('account')
                                                <div class="text-danger offset-3">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    <div id="rowContainer">
                                        <div class="row offering-row">

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="amount">Amount</label>
                                                    <input type="text" name="amount" id="amount" required=""
                                                        class="form-control col-md-8" placeholder="Enter amount"
                                                        value="{{ old('amount', $payment->amount) }}">
                                                </div>
                                                @error('amount')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                       
                                            <div class="col-md-6 pl-2">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2">Date</label>
                                                    <div class="input-group date col-md-6" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="text" name="date"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate" placeholder="Enter date"
                                                            data-toggle="datetimepicker" value="{{ old('date', \Carbon\Carbon::parse($payment->date)->format('m/d/Y')) }}" />
                                                    </div>
                                                    @error('date')
                                                        <div class="text-danger offset-3">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="notes">Notes</label>
                                                    <textarea class="form-control col-md-8" type="text" name="notes" id="notes" class="form-control"
                                                        placeholder="Enter Notes" value="">{{ old('notes', $payment->notes) }}</textarea>
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
                                            <button
                                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2">Update</button>
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
            $(document).ready(function() {
                
                $("#from_account").on('change', function(e) {
                    e.preventDefault();
                    var to_account = $("#to_account").val();
                    var from_account = $("#from_account").val(); 
                    if (to_account == from_account) {
                        toastr.error('From Account And To Account Can Not Be Same!');
                        // Clear the Select2 dropdown value
                        $("#from_account").val(null).trigger('change');
                    }
                });
                
                $("#to_account").on('change', function(e) {
                    e.preventDefault();
                    var to_account = $("#to_account").val();
                    var from_account = $("#from_account").val(); 
                    if (to_account == from_account) {
                        toastr.error('From Account And To Account Can Not Be Same!');
                        // Clear the Select2 dropdown value
                        $("#to_account").val(null).trigger('change');
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
