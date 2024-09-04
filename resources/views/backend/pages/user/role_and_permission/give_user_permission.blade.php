@extends('backend.layouts.master')

@section('title')
    Give User Permission
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header bg-white">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <p class="manu-name">@yield('title')</p>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <hr>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Give User Permission</h3>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('store-user-permission') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="user_id">Select User</label>
                                        <select class="form-control select2bs4" name="user_id" id="user_id"
                                            data-placeholder="Select User" style="width: 30%">
                                            <option selected>Select User</option>
                                            @foreach ($users as $user)
                                                @if (isset($request))
                                                    <option {{ $request->id == $user->id ? 'selected' : '' }}
                                                        value="{{ $user->id }}"> {{ encriptMemberId($user->id) }} {{ $user->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $user->id }}">{{ encriptMemberId($user->id) }} {{ $user->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="zTreeDemoBackground left">
                                        <ul id="treeDemo" class="ztree"></ul>
                                    </div>
                                    <div class="footer">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/plugins/z-tree') }}/css/zTreeStyle/zTreeStyle.css" type="text/css">
    @endpush

    @push('js')
        <script type="text/javascript" src="{{ asset('backend/plugins/z-tree') }}/js/jquery.ztree.core.js"></script>
        <script type="text/javascript" src="{{ asset('backend/plugins/z-tree') }}/js/jquery.ztree.excheck.js"></script>
        <script type="text/javascript" src="{{ asset('backend/plugins/z-tree') }}/js/jquery.ztree.exedit.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#user_id").change(function(e) {
                    e.preventDefault();
                    var user_id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('check-user-permission') }}",
                        data: {
                            user_id: user_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            var setting = {
                                edit: {
                                    enable: true,
                                    showRemoveBtn: false,
                                    showRenameBtn: false
                                },
                                check: {
                                    enable: true
                                },
                                data: {
                                    simpleData: {
                                        enable: true
                                    }
                                },
                                callback: {
                                    onCheck: myOnCheck,
                                    onClick: myOnCheck,
                                },
                                view: {
                                    fontCss: {
                                        fontsize: "20px"
                                    }
                                }
                            };

                            var zNodes = response;

                            var treeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);

                            function myOnCheck(event, treeId, treeNode) {
                                var nodes = treeObj.getCheckedNodes(true);
                                var checkedNodes = JSON.stringify(nodes);

                                $.ajax({
                                    type: "POST",
                                    url: "{{ url('user-excess-in-card') }}",
                                    data: {
                                        user_id: user_id,
                                        nodes: checkedNodes
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: function(response) {

                                    }
                                });
                            };

                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
