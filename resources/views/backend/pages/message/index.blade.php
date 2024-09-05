@extends('backend.layouts.master')
@section('title', 'Messages')
@section('content')
    <div class="content-wrapper">
        <div class="content-header bg-white">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <p class="manu-name">@yield('title')</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <hr>
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Messages Table</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Comment ID</th>
                                            <th>User ID</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $message)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $message->comment_id }}</td>
                                                <td>{{ $message->user_id }}</td>
                                                <td>{{ $message->created_at }}</td>
                                                <td>{{ $message->updated_at }}</td>
                                                <td>
                                                    <a href=""class="btn btn info">Edit</a>
                                                    <form action="" method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </section>
    </div>

    @push('js')
    @endpush
@endsection
