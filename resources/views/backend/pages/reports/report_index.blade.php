@extends('backend.layouts.master')
@section('title', 'Report')
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
                            {{--  <a href="{{ url('add-account') }}"
                                class="btn border border-primary btn-outline-primary me-2 btn-sm mr-2 mbtn">Add Account</a>  --}}
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
        <section class="content">
            <div class="container-fluid">
                <form id="filterForm" action="{{ url('reports') }}">
                    <div class="row my-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="account_id">Account</label>
                                <select class="form-control select2bs4" name="account_id" id="account_id" style="width: 100%">
                                    <option value="" {{ $selectedAccount == '' ? 'selected' : '' }}>All</option>
                                    @foreach ($accounts as $index => $account)
                                        <option value="{{ $account->id }}" {{ $selectedAccount == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="member_id">Member</label>
                                <select class="form-control select2bs4" name="member_id" id="member_id" style="width: 100%">
                                    <option value="" {{ $selectedMember == '' ? 'selected' : '' }}>All</option>
                                    @foreach ($members as $index => $member)
                                        <option value="{{ $member->id }}" {{ $selectedMember == $member->id ? 'selected' : '' }}>
                                            {{ encriptMemberId($member->id) }} {{ $member->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="form-control select2bs4" name="year" id="year" style="width: 100%">
                                    <option value="" {{ $selectedYear == '' ? 'selected' : '' }}>All</option>
                                    @for ($year = 2030; $year >= 2015; $year--)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
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
                                <div id="bar_report_income_expense"></div>
                            </div>
                        </div>
                    </section>


                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('js')
    <script>
        $(document).ready(function() {
            $('#account_id, #member_id, #year').on('change', function() {
                $('#filterForm').submit();
            });
    
            $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                $('#filterForm').submit();
            });
    
            $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val(''); // or use a default value like 'From date to date'
                $('#filterForm').submit();
            });
    
            // Data from Laravel Blade
            var categories = @json($categories);
            var postOfferingData = @json($postOffering);
    
            // Initialize the chart with dynamic data
            var options = {
                series: [{
                    name: 'Post Offering',
                    data: postOfferingData
                }],
                chart: {
                    type: 'bar',
                    height: 500
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categories,
                },
                yaxis: {
                    title: {
                        text: '$ (dolors)'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$ " + val + " ";
                        }
                    }
                }
            };
    
            var chart = new ApexCharts(document.querySelector("#bar_report_income_expense"), options);
            chart.render();
        });
    </script>
    
    @endpush
@endsection
