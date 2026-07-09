
@extends('company.layout.master')
@section('content')
@section('title', 'View Customer')
@php $page = 'orders'; @endphp


    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Marketer</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">All Customers</li>
                    </ol>
                </div>
            </div>
            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('company.marketers.side_inc')
                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                    <div class="content" id="tableContent">

                                        <div class="canvas-wrapper">


                                                <table id="example" class="table no-margin" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Job&nbsp;Type</th>
                                                            <th>Quantity</th>
                                                            {{-- <th>Ink</th>
                                                            <th>Paper&nbsp;Type</th> --}}
                                                            {{-- <th>Production&nbsp;Days</th> --}}
                                                            <th>Cost</th>
                                                            <th>Percentage (%)</th>
                                                            <th>Commission</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $total_commission = 0; @endphp
                                                        @foreach ($job_orders as $index => $val)
                                                            @php 
                                                                // 1. Safely pull data from jobDetails relations, fall back cleanly if missing
                                                                $job_detail_name = $val->jobDetails->job_order_name ?? 'Unknown Job';
                                                                $job_title = str_replace(' ', '_', $job_detail_name);
                                                                
                                                                // 2. Clean and cast the total cost to numeric format
                                                                $raw_cost = $val->jobDetails->total_cost ?? 0;
                                                                $clean_cost = (float) str_replace(',', '', $raw_cost);
                                                                
                                                                // 3. Compute commission amounts
                                                                $item_commission = ($val->percentage / 100) * $clean_cost;
                                                                $total_commission += $item_commission;
                                                            @endphp

                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                
                                                                {{-- Job Order Name --}}
                                                                <td>{{ $job_detail_name }}</td>
                                                                
                                                                {{-- Quantity --}}
                                                                <td>{{ $val->jobDetails->quantity ?? 0 }}</td>
                                                                
                                                                {{-- Total Cost Column --}}
                                                                <td>
                                                                    ₦{{ number_format($clean_cost, 2) }}
                                                                </td>
                                                                
                                                                {{-- Percentage --}}
                                                                <td>{{ $val->percentage }}%</td>
                                                                
                                                                {{-- Commission Column --}}
                                                                <td>
                                                                    ₦{{ number_format($item_commission, 2) }}
                                                                </td>
                                                                
                                                                {{-- Status --}}
                                                                <td>{{ $val->jobDetails->status ?? 'N/A' }}</td>
                                                                
                                                                {{-- View Link --}}
                                                                <td>
                                                                    <a href="{{ route('company.job_order.view_order', [$job_title, $val->id]) }}">
                                                                        <span><i class="fa fa-eye"></i></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                         <tfoot>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>
                                                                    <td style="font-weight:bolder">Total: {{'₦'.$total_commission}} </td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


