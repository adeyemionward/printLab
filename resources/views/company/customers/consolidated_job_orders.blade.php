@extends('company.layout.master')
@section('content')
@section('title', 'Consolidated Job Orders')
@php $page = 'consolidated_orders'; @endphp

<div class="content">
    <div class="container-fluid">
        <div class="row mt-2 align-items-center">
            <div class="col-md-6 float-start">
                <h4 class="m-0 text-dark text-muted">
                    Consolidated Job Invoice for {{ $customer->firstname . ' ' . $customer->lastname }}
                </h4>
                {{-- <small class="text-muted">Brand: {{ config('app.name', 'Printlabs') }}</small> --}}
            </div>
            <div class="col-md-6 text-end">
                <div class="d-inline-flex align-items-center gap-2">
                    <!-- Master Consolidated Invoice PDF Button -->
                    {{-- <a href=""
                       target="_blank"
                       class="btn btn-danger btn-sm shadow-sm">
                        <i class="fa fa-file-pdf-o me-1"></i> Download Consolidated PDF
                    </a> --}}

                    <ol class="breadcrumb float-end mb-0 d-inline-block ps-2">
                        <li class="breadcrumb-item"><a href="#">Customer Job Invoice</a></li>
                        <li class="breadcrumb-item active">All Orders</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="canvas-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            @include('company.customers.side_inc')
                            <div class="col-md-9 col-xl-9">
                                <div class="card">
                                    <div class="content" id="tableContent">
                                        <div class="canvas-wrapper">
                                            @include('company.customers.order_date_range')

                                            <table id="example" class="table no-margin table-bordered align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Order&nbsp;No</th>
                                                        
                                                        <th>Date</th>
                                                        <th>Total Cost</th>
                                                        <th>Amount Paid</th>
                                                        <th>Outstanding</th>
                                                        <th class="text-center" style="width: 10%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $grandTotalCost = 0;
                                                        $grandTotalPaid = 0;
                                                        $grandTotalOutstanding = 0;
                                                    @endphp

                                                    @foreach ($job_orders as $index => $val)
                                                        @php
                                                            $order_cost = (float) str_replace(',', '', $val->total_cost ?? 0);
                                                            $paid_amount = (float) str_replace(',', '', $val->amount_paid ?? 0);
                                                            $outstanding = max(0, $order_cost - $paid_amount);

                                                            $grandTotalCost += $order_cost;
                                                            $grandTotalPaid += $paid_amount;
                                                            $grandTotalOutstanding += $outstanding;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <a style="color: blue; font-weight: 600;" href="{{ route('company.job_order.view_order', [$val->id]) }}">
                                                                    #{{ $val->order_no }}
                                                                </a>
                                                                <br>
                                                                <span class="badge bg-light text-dark border mt-1">
                                                                    {{ $val->total_jobs }} {{ \Illuminate\Support\Str::plural('Job', $val->total_jobs) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $val->created_at ? \Carbon\Carbon::parse($val->created_at)->format('d M, Y') : 'N/A' }}</td>
                                                           
                                                            <td>&#8358;{{ number_format($order_cost, 2) }}</td>
                                                            <td class="text-success">&#8358;{{ number_format($paid_amount, 2) }}</td>
                                                            <td class="{{ $outstanding > 0 ? 'text-danger fw-bold' : 'text-muted' }}">
                                                                &#8358;{{ number_format($outstanding, 2) }}
                                                            </td>
                                                             <td class="text-center">
                                                                <!-- View Details Link -->
                                                                <a href="{{ route('company.job_order.view_order', [$val->id]) }}"
                                                                   class="text-secondary me-2"
                                                                   title="View Order Details">
                                                                    <span><i class="fa fa-eye"></i></span>
                                                                {{-- </a> {{ route('company.job_order.consolidated_invoice_pdf', [$customer->id, 'date_from' => request('date_from'), 'date_to' => request('date_to')]) }} --}}

                                                                <!-- Single Order Invoice PDF -->
                                                                <a href="{{route('company.job_order.order_invoice_pdf',[$val->order_no])}}"
                                                                   target="_blank"
                                                                   class="text-danger"
                                                                   title="Download Single Order PDF">
                                                                    <i class="fas fa-file-pdf"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot style="font-weight: bold; background-color: #f8f9fa;">
                                                    <tr>
                                                        <td colspan="2" class="text-end" style="text-align: right;">Cumulative Summary:</td>
                                                        <td>&#8358;{{ number_format($grandTotalCost, 2) }}</td>
                                                        <td class="text-success">&#8358;{{ number_format($grandTotalPaid, 2) }}</td>
                                                        <td class="{{ $grandTotalOutstanding > 0 ? 'text-danger' : 'text-muted' }}">
                                                            &#8358;{{ number_format($grandTotalOutstanding, 2) }}
                                                        </td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
