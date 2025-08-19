
@extends('company.layout.master')
@section('content')
@section('title', 'Profit/Loss Report')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Profit/Loss Report</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Profit/Loss</a></li>
                        <li class="breadcrumb-item active">All Profit/Loss</li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">
                    <div class="canvas-wrapper">
                        @include('company.includes.date_range')
                        <table id="example1" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 70%;">Job Order</th>
                                    <th style="width: 30%;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Group the collection by the job order name.
                                    // This creates a new collection where each item is a group of orders.
                                    $groupedOrders = $ordersPayHistory->groupBy(function($item) {
                                        return $item->jobOrder->job_order_name;
                                    });

                                    $total_income = 0; // Initialize grand total
                                @endphp

                                @foreach ($groupedOrders as $jobName => $ordersInGroup)
                                    @php
                                        // Sum the total_pay for all items within this group
                                        $groupTotal = $ordersInGroup->sum('total_pay');
                                        $total_income += $groupTotal; // Add this group's total to the grand total
                                    @endphp
                                    <tr>
                                        <td style="width: 70%;">{{ $jobName }}</td>
                                        <td style="width: 30%;">&#8358;{{ number_format($groupTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="width: 70%;">Total Income</th>
                                    <th style="width: 30%;">&#8358;{{number_format($total_income, 2)}}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <br><br>
                        <table id="example1" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 70%;">Expenses</th>
                                    <th style="width: 30%;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_expenses = 0; @endphp

                                @foreach ($expensesPayHistory as $expense_val)

                                    @php $total_expenses += $expense_val->total_pay @endphp
                                    <tr>
                                        <td style="width: 70%;">{{$expense_val->category_name}}</td>
                                        <td style="width: 30%;">&#8358;{{number_format($expense_val->total_pay,2)}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="width: 70%;">Total Expenses</th>
                                    <th style="width: 30%;">&#8358;{{number_format($total_expenses, 2)}}</th>
                                </tr>
                            </tfoot>
                        </table>

                        <br><br>
                        <table id="example1" class="table no-margin" style="width:100%">
                            <tfoot>
                                <tr>
                                    <th style="width: 70%;">Profit/Loss</th>
                                    <th style="width: 30%;">&#8358;{{number_format($total_income - $total_expenses, 2)}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

