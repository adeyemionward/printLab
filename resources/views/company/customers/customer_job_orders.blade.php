@extends('company.layout.master')
@section('content')
@section('title', 'Customer Job Orders')
@php $page = 'orders'; @endphp

<div class="content">
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6 float-start">
                <h4 class="m-0 text-dark text-muted">Job Orders for {{ $customer->firstname . ' ' . $customer->lastname }}</h4>
                <small class="text-muted">Brand: {{ config('app.name', 'Company Portal') }}</small>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb float-end">
                    <li class="breadcrumb-item"><a href="#">Customer Job Order</a></li>
                    <li class="breadcrumb-item active">All Orders</li>
                </ol>
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
                                                        <th>Customer</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($job_orders as $index => $val)
                                                        @php
                                                            $job_title = str_replace(' ', '_', $val->job_order_name);
                                                            $order_cost = (float) str_replace(',', '', $val->total_cost ?? 0);
                                                            $jobCount = $val->total_jobs ?? ($val->jobs ? $val->jobs->count() : 1);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <a style="color: blue; font-weight: 600;" href="{{ route('company.job_order.view_order', [$val->id]) }}">
                                                                    #{{ $val->order_no }}
                                                                </a>
                                                                <br>
                                                                <span class="badge bg-light text-dark border mt-1">
                                                                    {{ $jobCount }} {{ \Illuminate\Support\Str::plural('Job', $jobCount) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $val->user->company_name ?? ($customer->firstname . ' ' . $customer->lastname) }}</td>
                                                            <td>&#8358;{{ number_format($order_cost, 2) }}</td>
                                                            <td>
                                                                @if($val->cart_order_status == 1)
                                                                    <span style="color: blue;">In cart</span>
                                                                @elseif($val->cart_order_status == 2)
                                                                    <span style="color: green;">Completed</span>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $val->created_at ? \Carbon\Carbon::parse($val->created_at)->format('d M, Y') : 'N/A' }}</td>
                                                            <td>
                                                                <a href="{{ route('company.job_order.view_order', [$val->id]) }}">
                                                                    <span><i class="fa fa-eye"></i></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
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
