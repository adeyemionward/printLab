
@extends('company.layout.master')
@section('content')
@section('title', 'Debtors Report')
    <div class="content">
        <div class="container-fluid">
            {{-- Header --}}
        <div class="row mt-2 mb-3">
            <div class="col-md-6">
                <h4 class="m-0 text-dark text-muted">
                    Company Payment History
                </h4>

                <h6 class="text-primary mt-1">
                    {{ $job_pay->first()->user->company_name ?? '' }}
                </h6>
            </div>

            <div class="col-md-6 text-end">

                <a href="{{ route('company.finance.report.debtors.all_debtors') }}" class="btn btn-sm btn-secondary mt-2">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

            <div class="card">
                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Cost</th>
                                    <th>Amount&nbsp;Paid</th>
                                    <th>Outstanding</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                @php $totalDebt = 0; @endphp
                               @foreach ($job_pay as $val)

                                    @php
                                        $paid = $val->jobPaymentHistories->sum('amount');
                                        $outstanding = $val->total_cost - $paid;

                                        // Skip fully paid orders
                                        if ($outstanding <= 0) continue;

                                        $totalDebt += $outstanding;
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ '₦' . number_format($val->total_cost) }}</td>

                                        <td>{{ '₦' . number_format($paid) }}</td>

                                        <td>{{ '₦' . number_format($outstanding) }}</td>

                                        <td>
                                            <a href="{{ route('company.job_order.view_order', [$val->id]) }}" class="btn btn-sm btn-outline-primary">
                                                View Order
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                                <tfoot>
                                    <tr>

                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><b>Total Outstanding</b></td>
                                        <td><b>{{'₦'.number_format($totalDebt)}}</b></td>
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

