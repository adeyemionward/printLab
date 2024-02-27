

@extends('admin.layout.master')
@section('content')
@section('title', 'Active Subscription')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Active Subscription</h4>
                </div>
                {{-- <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <a href="{{route('finance.expenses.add_expense')}}"><li class="active btn btn-primary" style="">Add Expense </li></a>
                    </ol>
                </div> --}}
            </div>

            <div class="card">
                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">
                        @include('includes.date_range')
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Company</th>
                                    <th>Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Payment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($active_subscription as $val)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$val->title}}</td>
                                        <td>{{$val->supplierCompany->company_name}}</td>
                                        <td>{{$val->categoryName->category_name}}</td>
                                        <td>&#8358;{{$val->total_cost}}</td>

                                        <td>{{$val->payment_type}}</td>
                                        <td>{{$val->expenseHistories->sum('amount_paid')}}</td>
                                        <td>{{date('D M d, Y', strtotime($val->expense_date))}}</td>
                                        <td><a href="{{route('finance.expenses.view_expense',[$val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

