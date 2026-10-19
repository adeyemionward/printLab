
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
            @foreach ($job_pay as $val)
                @php
                    $outstanding = $val->outstanding ?? 0;
                    if ($outstanding <= 0) continue;
                    $totalDebt += $outstanding;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($val->user)->firstname . ' ' . optional($val->user)->lastname }}</td>
                    <td>{{ optional($val->user)->company_name }}</td>
                    <td>{{ '₦' . number_format($val->total_cost) }}</td>
                    <td>{{ '₦' . number_format($val->total_paid) }}</td>
                    <td>{{ '₦' . number_format($outstanding) }}</td>
                    <td>
                        <a href="{{ route('company.finance.all_payment_history', optional($val->user)->id ?? '') }}"
                           class="btn btn-sm btn-outline-primary">
                            Payment History
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">&nbsp;</td>
                <td><b>Total Outstanding</b></td>
                <td><b>{{ '₦' . number_format($totalDebt) }}</b></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    @endif

    @if (!request()->has('customer'))
        <tbody>
            @php
                $totalOutstandingDebt = 0;
                $amountPaid = 0;
                $currentYearDebt = 0;

                // Matches the dashboard model/query to get the exact company-wide total (₦6,373,792)
                $totalCost = \App\Models\JobOrder::where('company_id', app('company_id'))
                    ->where('cart_order_status', 2)
                    ->whereYear('created_at', \Carbon\Carbon::now()->year)
                    ->sum('total_cost');
            @endphp

            {{-- Calculate Previous Year Outstanding --}}
            @foreach ($previousYearOrders1 as $val)
                @php
                    $paid = $val->jobPaymentHistories->sum('amount');
                    $balance = $val->total_cost - $paid;
                    if ($balance <= 0) continue;
                    $totalOutstandingDebt += $balance;
                @endphp
            @endforeach

            {{-- Current Year Customer Debts --}}
            @foreach ($customerDebts as $entry)
                @php
                    $paidAmount = \App\Models\JobPaymentNewHistory::getTotalPaidForUserInCurrentYear($entry['user_id']);
                    $currentOutstanding = $entry['total_cost'] - $paidAmount;

                    $amountPaid += $paidAmount;
                    $currentYearDebt += $currentOutstanding;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $entry['name'] }}</td>
                    <td>{{ $entry['company'] }}</td>
                    <td>₦{{ number_format($entry['total_cost']) }}</td>
                    <td>₦{{ number_format($paidAmount) }}</td>
                    <td>₦{{ number_format($currentOutstanding) }}</td>
                    <td>
                        <a href="{{ route('company.customers.customer_job_orders', [$entry['user_id']]) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td><b>{{ '₦' . number_format($totalCost) }}</b></td>
                <td><b>{{ '₦' . number_format($amountPaid) }}</b></td>
                <td><b>{{ '₦' . number_format($currentYearDebt) }}</b></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
                <td><b>Previous Year Outstanding</b></td>
                <td><b>{{ '₦' . number_format($totalOutstandingDebt) }}</b></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
                <td><b>Total Outstanding</b></td>
                <td><b>{{ '₦' . number_format($totalOutstandingDebt + $currentYearDebt) }}</b></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    @endif
</table>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

