
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if (request()->has('customer'))
                                <tbody>
                                @php $totalDebt = 0; @endphp
                                @foreach ($job_pay  as $val)
                                    @php
                                        // if ($val->total_cost == $val->jobPaymentHistories->sum('amount')) continue;
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
                                        {{-- <td>{{$val->status}}</td> --}}
                                        <td><a href="{{route('company.job_order.view_order',[$val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
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
                                    </tr>
                                </tfoot>

                            @endif
                            @if (!request()->has('customer'))
                                <tbody>
                                    @php $totalOutstandingDebt = 0; $totalCost = 0; $amountPaid = 0; $currentYearDebt = 0; @endphp
                                    @foreach ($previousYearOrders1 as $val)
                                        @php
                                            $paid = $val->jobPaymentHistories->sum('amount');
                                            $balance = $val->total_cost - $paid;
                                            if ($balance <= 0) continue;
                                            $totalOutstandingDebt += $balance;
                                        @endphp
                                    @endforeach

                                    @foreach ($customerDebts as $entry)
                                        @php
                                            $totalCost += $entry['total_cost'];
                                            $amountPaid += $entry['total_paid'];
                                            $currentYearDebt += $entry['balance'];
                                            // $previous_years  += $entry['previous_years'];
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $entry['name'] }}</td>
                                            <td>{{ $entry['company'] }}</td>
                                            <td>₦{{ number_format($entry['total_cost']) }}</td>
                                             <td>₦{{ number_format(\App\Models\JobPaymentNewHistory::getTotalPaidForUser($entry['user_id'])) }}</td>
                                            <td>₦{{ number_format($entry['balance']) }}</td>
                                            <td><a href="{{ route('company.customers.customer_job_orders',[$entry['user_id']])}}"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr>

                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><b>{{'₦'.number_format($totalCost)}}</b></td>
                                            <td><b>{{'₦'.number_format($amountPaid)}}</b></td>
                                            <td><b>{{'₦'.number_format($currentYearDebt)}}</b></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>

                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><b>Previous Year Outstanding</b></td>
                                            <td><b>{{'₦'.number_format(($totalOutstandingDebt + $currentYearDebt) - $currentYearDebt)}}</b></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td><b>Total Outstanding</b></td>
                                            <td><b>{{'₦'.number_format($totalOutstandingDebt + $currentYearDebt)}}</b></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>

                                </tbody>
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

