
@extends('backend.layouts.master')
@section('title', 'Edit Account')
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
                        <a href="{{ url('accounts') }}" class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Accounts</a>
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
                <br>
                <form action="{{ route('update-account', ['id'=> $account->id]) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 connectedSortable">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-4 mt-2" for="name">Name</label>
                                            <input type="text" name="name" id="name" required=""
                                                class="form-control col-md-7" placeholder="Enter account name"
                                                value="{{ old('name', $account->name) }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-4 mt-2" for="balance">Starting Balance</label>
                                            <input type="number" name="balance" id="balance" required=""
                                                class="form-control col-md-7" placeholder="Enter account balance"
                                                value="{{ old('balance', $account->startingBalance->amount) }}">
                                            @error('balance')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
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
