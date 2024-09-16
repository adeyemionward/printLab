
@extends('company.layout.master')
@section('content')
@section('title', 'Debtors Report')
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
                        @include('company.includes.finance_date_range')
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer&nbsp;Name</th>
                                    <th>Company Name</th>
                                    <th>Cost</th>
                                    <th>Amount&nbsp;Paid</th>
                                    <th>Outstanding</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalDebt = 0; @endphp
                                @foreach ($job_pay  as $val)
                                @php
                                    if ($val->total_cost == $val->jobPaymentHistories->sum('amount')) continue;
                                    $totalDebt += $val->total_cost - $val->jobPaymentHistories->sum('amount')
                                @endphp
                                @php $job_title = str_replace(' ','_', $val->job_order_name) ; $rr =   0;   @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$val->user->firstname.' '. $val->user->lastname}}</td>
                                        <td>{{$val->user->company_name}}</td>
                                        <td>{{'₦'.number_format($val->total_cost)}} </td>
                                        <td>{{'₦'.number_format($val->jobPaymentHistories->sum('amount'))}}</td>
                                        <td>{{'₦'.number_format($val->total_cost - $val->jobPaymentHistories->sum('amount'))}}</td>
                                        <td>{{$val->status}}</td>
                                        <td><a href="{{route('company.job_order.view_order',[$job_title, $val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>

                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><b>Total Outstanding</b></td>
                                        <td><b>{{'₦'.number_format($totalDebt)}}</b></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

