
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
                                <th>Customer Name</th>
                                <th>Company Name</th>
                                <th>Prev. Outstanding (B/F)</th>
                                <th>Current Cost</th>
                                <th>Current Paid</th>
                                <th>Current Balance</th>
                                <th>Total Outstanding</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @if (!request()->has('customer'))
                            <tbody>
                                @foreach ($customerDebts as $index => $entry)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $entry['name'] }}</td>
                                        <td>{{ $entry['company'] ?? 'N/A' }}</td>
                                        <td>
                                            @if($entry['previous_outstanding'] > 0)
                                                <!-- Added ?filter=previous to target past orders only -->
                                                <a href="{{ route('company.customers.consolidated_job_orders', [$entry['user_id']]) }}?filter=previous" style="color: #d9534f; font-weight: 600;" title="View past orders">
                                                    ₦{{ number_format($entry['previous_outstanding']) }} <i class="fa fa-external-link-alt"></i>
                                                </a>
                                            @else
                                                ₦0.00
                                            @endif
                                        </td>
                                        <td>₦{{ number_format($entry['current_cost']) }}</td>
                                        <td>₦{{ number_format($entry['current_paid']) }}</td>
                                        <td>₦{{ number_format($entry['current_outstanding']) }}</td>
                                        <td><b>₦{{ number_format($entry['total_outstanding']) }}</b></td>
                                        <td>
                                            <a href="{{ route('company.customers.consolidated_job_orders', [$entry['user_id']]) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right;"><b>Grand Totals:</b></td>
                                    <td><b>₦{{ number_format($grandPreviousDebt) }}</b></td>
                                    <td><b>₦{{ number_format($grandTotalCost) }}</b></td>
                                    <td><b>₦{{ number_format($grandTotalPaid) }}</b></td>
                                    <td><b>₦{{ number_format($grandCurrentDebt) }}</b></td>
                                    <td><b>₦{{ number_format($grandPreviousDebt + $grandCurrentDebt) }}</b></td>
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

