
@extends('company.layout.master')
@section('content')
@section('title', 'Creditors Report')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Creditors</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Creditors</a></li>
                        <li class="breadcrumb-item active">All Creditors</li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">
                        @include('company.includes.date_range')
                       <table id="example" class="table no-margin" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Expense Title</th>
                                <th>Supplier</th>
                                <th>Category</th>
                                <th>Payment Type</th>
                                <th>Total Cost</th>
                                <th>Amount Paid</th>
                                <th>Amount Remaining</th>
                                <th>Payment Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $serialNo = 1;
                                $sumTotalCost = 0;
                                $sumAmountPaid = 0;
                                $sumRemaining = 0;
                            @endphp
                            @foreach ($expenses as $val)
                                @php
                                    $amountPaid = $val->expenseHistories->sum('amount_paid');
                                    $remainingBalance = $val->total_cost - $amountPaid;

                                    // Accumulate totals
                                    $sumTotalCost += $val->total_cost;
                                    $sumAmountPaid += $amountPaid;
                                    $sumRemaining += $remainingBalance;
                                @endphp
                                <tr>
                                    <td>{{ $serialNo++ }}</td>
                                    <td>{{ $val->title }}</td>
                                    <td>{{ @$val->supplierCompany->company_name ?? 'N/A' }}</td>
                                    <td>{{ @$val->categoryName->category_name ?? 'N/A' }}</td>
                                    <td>{{ $val->payment_type }}</td>
                                    <td>&#8358;{{ number_format($val->total_cost, 2) }}</td>
                                    <td>&#8358;{{ number_format($amountPaid, 2) }}</td>
                                    <td>&#8358;{{ number_format($remainingBalance, 2) }}</td>
                                    <td>{{ date('D M d, Y', strtotime($val->expense_date)) }}</td>
                                    <td>
                                        <a href="{{ route('company.finance.expenses.view_expense', [$val->id]) }}">
                                            <span><i class="fa fa-eye"></i></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align: right;"> </th>
                                <th>&#8358;{{ number_format($sumTotalCost, 2) }}</th>
                                <th>&#8358;{{ number_format($sumAmountPaid, 2) }}</th>
                                <th>&#8358;{{ number_format($sumRemaining, 2) }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

