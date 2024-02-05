
@extends('layout.master')
@section('content')
@section('title', 'Profit/Loss Report')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Debtors</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Debtors</a></li>
                        <li class="breadcrumb-item active">All Debtors</li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">
                    <div class="canvas-wrapper">
                        @include('includes.date_range')
                        <table id="example1" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Income</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_income = 0; @endphp

                                @foreach ($ordersPayHistory as $order_val)

                                    @php $total_income += $order_val->total_pay @endphp
                                    <tr>
                                        <td>{{$order_val->job_order_name}}</td>
                                        <td>&#8358;{{number_format($order_val->total_pay,2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Income</th>
                                    <th>&#8358;{{number_format($total_income, 2)}}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <br><br>
                        <table id="example1" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Expenses</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_expenses = 0; @endphp

                                @foreach ($expensesPayHistory as $expense_val)

                                    @php $total_expenses += $expense_val->total_pay @endphp
                                    <tr>
                                        <td>{{$expense_val->category_name}}</td>
                                        <td>&#8358;{{number_format($expense_val->total_pay,2)}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Expenses</th>
                                    <th>&#8358;{{number_format($total_expenses, 2)}}</th>
                                </tr>
                            </tfoot>
                        </table>

                        <br><br>
                        <table id="example1" class="table no-margin" style="width:100%">
                            <tfoot>
                                <tr>
                                    <th>Profit/Loss</th>
                                    <th>&#8358;{{number_format($total_income - $total_expenses, 2)}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

