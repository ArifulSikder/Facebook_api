@extends('backend.layouts.master')
@section('title', 'Pages')
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
                                <h3 class="card-title">Page Table</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Page ID</th>
                                            <th>Access Token</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pages as $page)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $page->page_id }}</td>
                                                <td>{{ $page->access_token }}</td>
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
