<div class="row offering-row{{ $id }}">
    <div class="col-md-6">
        <div class="form-group row">
            <label class="col-md-3 mt-2" for="amount{{ $id }}">Amount</label>
            <input type="text" name="amount[]" id="amount{{ $id }}" required=""
                class="form-control col-md-8" placeholder="Enter amount"
                value="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label class="col-md-3 mt-2" for="account">Account</label>
            <select class="form-control select2bs4 col-md-8" name="account[]"
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
            <label class="col-md-3 mt-2" for="type{{ $id }}">Type</label>
            <select class="form-control select2bs4 col-md-8 payment_type" name="type[]" id="type{{ $id }}" data-row_id="{{ $id }}">
                <option value="" selected="selected">Select Account</option>
                @foreach ($payment_types as $type)
                    <option value="{{ $type->id }}">{{ $type->payment_type_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6 d-none" id="check_row{{ $id }}" data-row_id="check_row{{ $id }}">
        <div class="form-group row">
            <label class="col-md-3 mt-2" for="check_number{{ $id }}">Check Number</label>
            <input type="text" name="check_number[]" id="check_number{{ $id }}" 
                class="form-control col-md-8" placeholder="Enter amount"
                value="">
        </div>
    </div>
</div>
<hr>