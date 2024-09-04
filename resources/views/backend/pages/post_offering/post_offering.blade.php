@extends('backend.layouts.master')
@section('title', 'Post Offering')
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
                            {{--  <a href="{{ url('post-offering') }}"
                               class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Post Offering</a>  --}}
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
                        <form action="{{ route('store-post-offering') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" id="member">Member</label>
                                                <select class="form-control select2bs4 col-md-8" name="member"
                                                    id="member">
                                                    <option value="" selected="selected">Select member</option>
                                                    @foreach ($members as $member)
                                                        <option value="{{ $member->id }}">{{ encriptMemberId($member->id) }} {{ $member->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-2">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2">Date</label>
                                                <div class="input-group date col-md-6" id="reservationdate"
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
                                        <hr>
                                        <div class="row offering-row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="amount">Amount</label>
                                                    <input type="text" name="amount[]" id="amount" required=""
                                                        class="form-control col-md-8" placeholder="Enter amount"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="account">Account</label>
                                                    <select class="form-control select2bs4 col-md-6" name="account[]"
                                                        id="account" required>
                                                        <option value="" selected="selected">Select Account</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="type">Type</label>
                                                    <select class="form-control select2bs4 col-md-8" name="type[]"
                                                        id="type" required>
                                                        <option value="" selected="selected">Select Account</option>
                                                        @foreach ($payment_types as $type)
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->payment_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none" id="check_row">
                                                <div class="form-group row">
                                                    <label class="col-md-3 mt-2" for="check_number">Check Number</label>
                                                    <input type="text" name="check_number[]" id="check_number"
                                                        class="form-control col-md-8" placeholder="Enter amount"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="footer mr-4 pr-3">
                                        <div class="float-right d-flex">
                                            <button
                                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2">Save</button>
                                            <button type="button" id="addOfferingButton"
                                                class="btn border border-primary btn-outline-primary btn-sm mr-2">
                                                Additional Offering
                                            </button>
                                            <button type="button" id="cancelOfferingButton"
                                                class="btn border border-danger btn-outline-danger btn-sm d-none">
                                                Cancel
                                            </button>
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
                var my_row_id = 0;

                $("#addOfferingButton").click(function(e) {
                    e.preventDefault();
                    var isValid = my_row_id === 0 ? validateDefaultRows() : validateLastRow();
                    if (isValid) {
                        addNewRow();
                    } else {
                        alert('Please fill out all required fields before adding a new offering.');
                    }
                });

                function validateDefaultRows() {
                    var isValid = true;
                    $('.offering-row').each(function() {
                        let rowValid = true;
                        const amount = $(this).find('input[name="amount[]"]').val();
                        const account = $(this).find('select[name="account[]"]').val();
                        const type = $(this).find('select[name="type[]"]').val();
                        const check_number = $(this).find('input[name="check_number[]"]').val();

                        if (!amount) {
                            rowValid = false;
                            $(this).find('input[name="amount[]"]').addClass('is-invalid');
                        } else {
                            $(this).find('input[name="amount[]"]').removeClass('is-invalid');
                        }

                        if (!account) {
                            rowValid = false;
                            $(this).find('select[name="account[]"]').addClass('is-invalid');
                        } else {
                            $(this).find('select[name="account[]"]').removeClass('is-invalid');
                        }

                        if (!type) {
                            rowValid = false;
                            $(this).find('select[name="type[]"]').addClass('is-invalid');
                        } else {
                            $(this).find('select[name="type[]"]').removeClass('is-invalid');
                            if(type == 2){
                                if(!check_number){
                                    rowValid = false;
                                    $(this).find('input[name="check_number[]"]').addClass('is-invalid');
                                }else{
                                    $(this).find('input[name="check_number[]"]').removeClass('is-invalid');
                                }
                                
                            }
                        }

                        if (!rowValid) {
                            isValid = false;
                        }
                    });

                    return isValid;
                }

                function validateLastRow() {
                    var isValid = true;
                    $('.offering-row' + my_row_id).each(function() {
                        let rowValid = true;
                        const amount = $(this).find('input[name="amount[]"]').val();
                        const account = $(this).find('select[name="account[]"]').val();
                        const type = $(this).find('select[name="type[]"]').val();
                        const check_number = $(this).find('input[name="check_number[]"]').val();

                        if (!amount) {
                            rowValid = false;
                            $(this).find('input[name="amount[]"]').addClass('is-invalid');
                        } else {
                            $(this).find('input[name="amount[]"]').removeClass('is-invalid');
                        }

                        if (!account) {
                            rowValid = false;
                            $(this).find('select[name="account[]"]').addClass('is-invalid');
                        } else {
                            $(this).find('select[name="account[]"]').removeClass('is-invalid');
                        }

                        if (!type) {
                            rowValid = false;
                            $(this).find('select[name="type[]"]').addClass('is-invalid');
                        } else {
                            $(this).find('select[name="type[]"]').removeClass('is-invalid');
                            if(type == 2){
                                if(!check_number){
                                    rowValid = false;
                                    $(this).find('input[name="check_number[]"]').addClass('is-invalid');
                                }else{
                                    $(this).find('input[name="check_number[]"]').removeClass('is-invalid');
                                }
                            }
                        }

                        if (!rowValid) {
                            isValid = false;
                        }
                    });

                    return isValid;
                }

                // Add a new row
                function addNewRow() {
                    my_row_id++;
                    $('#cancelOfferingButton').addClass('d-block').removeClass('d-none');
                   
                    $.ajax({
                        type: "GET",
                        url: "{{ url('add-offering-ajax') }}",
                        data: {
                            id: my_row_id
                        },
                        success: function(data) {
                            $("#rowContainer").append(data.html);
                            $('.select2bs4').select2({
                                theme: 'bootstrap4'
                            });
                            $('html, body').animate({
                                scrollTop: $("#rowContainer .offering-row").last().offset().top
                            }, 500);
                        }
                    });
                }

                $("#cancelOfferingButton").click(function(e) {
                    if (my_row_id > 0) {
                        cancelLastRow(my_row_id);
                        my_row_id--; // Decrement the row ID after removing the row
                    }
                });
                
                function cancelLastRow(row_id) {
                    $('.offering-row' + row_id).remove();
                    console.log(row_id);
                    if (row_id === 1) { // After removing the first row, hide the button
                        $("#cancelOfferingButton").addClass('d-none').removeClass('d-block');
                    }
                }

                $(document).on('change', '.payment_type', function(e) {
                    e.preventDefault();
                    var type_id = $(this).val();
                    var row_id = $(this).data('row_id');

                    $.ajax({
                        type: "GET",
                        url: "{{ url('check-payment-type-ajax') }}",
                        data: {
                            type_id: type_id,
                            row_id: row_id
                        },
                        success: function(data) {
                            // Handle success response if needed
                        }
                    });
                });


                $("#type").on('change', function(e) {
                    e.preventDefault();
                    var type_id = $(this).val();
                    if (type_id == 1 || type_id == '') {
                        $("#check_row").removeClass('d-block').addClass('d-none');
                    } else if (type_id == 2) {
                        $("#check_row").removeClass('d-none').addClass('d-block');
                    }
                });

                $(document).on('change', ".payment_type", function(e) {
                    e.preventDefault();

                    var row_id = $(this).data('row_id');

                    var type_id = $(this).val();
                    if (type_id == 1 || type_id == '') {
                        $("#check_row" + row_id).removeClass('d-block').addClass('d-none');
                    } else if (type_id == 2) {
                        $("#check_row" + row_id).removeClass('d-none').addClass('d-block');
                    }
                });
            });
        </script>
    @endpush
@endsection
