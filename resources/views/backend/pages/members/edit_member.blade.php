@extends('backend.layouts.master')
@section('title', 'Edit Member')
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
                        <a href="{{ url('members') }}" class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Members</a>
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
                <form action="{{ route('update-member',[$member->id]) }}" method="POST">
                    @method("PUT")
                    @csrf
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 connectedSortable">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="name">Name</label>
                                                <input type="text" name="name" id="name" required=""
                                                    class="form-control col-md-8" placeholder="Enter member name"
                                                    value="{{ old('name', $member->name) }}">
                                                @error('name')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-2">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2">Birthday:</label>
                                                <div class="input-group date col-md-6" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="birthday" class="form-control datetimepicker-input"
                                                        data-target="#reservationdate" placeholder="Enter member's birthday"
                                                        data-toggle="datetimepicker" value="{{ old('birthday', \Carbon\Carbon::parse($member->birthday)->format('m/d/Y')) }}" />
                                                </div>
                                                @error('birthday')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="address">Address</label>
                                                <input type="text" name="address" id="address" required=""
                                                    class="form-control col-md-8" placeholder="Enter member's address"
                                                    value="{{ old('address', $member->address) }}">
                                                @error('address')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="city">City</label>
                                                <input type="text" name="city" id="city" required=""
                                                    class="form-control col-md-8" placeholder="Enter member's city"
                                                    value="{{ old('city', $member->city) }}">
                                                @error('city')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="state">State</label>
                                                <input type="text" name="state" id="state" required=""
                                                    class="form-control col-md-8" placeholder="Enter member's state"
                                                    value="{{ old('state', $member->state) }}">
                                                @error('state')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="zip">Zip</label>
                                                <input type="text" name="zip" id="zip" required=""
                                                    class="form-control col-md-8" placeholder="Enter member's zip"
                                                    value="{{ old('zip', $member->zip) }}">
                                                @error('zip')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="phone">Phone</label>
                                                <input type="text" name="phone" id="phone"
                                                    class="form-control col-md-8" placeholder="Enter member's phone"
                                                    value="{{ old('phone', $member->phone) }}">
                                                @error('phone')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="email">Email</label>
                                                <input type="email" name="email" id="email" 
                                                    class="form-control col-md-8" placeholder="Enter member's email"
                                                    value="{{ old('email', $member->email) }}">
                                                @error('email')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="password">Password</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control col-md-8" placeholder="Enter password"
                                                    value="">
                                                @error('password')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3 mt-2" for="password_confirmation">Confirm Password</label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                                    class="form-control col-md-8" placeholder="Enter confirm password"
                                                    value="">
                                                @error('password_confirmation')
                                                    <div class="text-danger offset-3">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer mr-4 pr-2">
                                        <div class="float-right">
                                            <button
                                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
        
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        
    </div>
@endsection
