
@extends('company.layout.master')
@section('content')
@section('title', 'All Expense')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Expenses</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('company.finance.expenses.add_expense')}}"><li class="active btn btn-primary" style="">Add Expense </li></a>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">
                        @include('company.includes.expense_date_range')
                       <table id="example" class="table no-margin" style="width:100%">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Expense Title</th>
            <th>Beneficiary</th>
            <th>Category</th>
            <th>Total Cost</th>
            <th>Payment Type</th>
            <th>Amount Paid</th>
            <th>Payment Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $totalCost = 0; $totalAmountPaid = 0; @endphp
        @foreach ($expenses as $index => $val)
            @php
                $paidSum = $val->expenseHistories->sum('amount_paid');
                $totalCost += (float) $val->total_cost;
                $totalAmountPaid += (float) $paidSum;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $val->title }}</td>
                <td>{{ @$val->supplierCompany->company_name ?? @$val->marketerName->firstname }}</td>
                <td>
                    @if($val->title == 'Commission')
                        Commission
                    @else
                        {{ @$val->categoryName->category_name }}
                    @endif
                </td>
                <td>&#8358;{{ number_format($val->total_cost, 2) }}</td>
                <td>{{ $val->payment_type }}</td>
                <td>&#8358;{{ number_format($paidSum, 2) }}</td>
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
            <td colspan="4" style="text-align: right;"><b>Totals:</b></td>
            <td><b>&#8358;{{ number_format($totalCost, 2) }}</b></td>
            <td></td>
            <td><b>&#8358;{{ number_format($totalAmountPaid, 2) }}</b></td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

