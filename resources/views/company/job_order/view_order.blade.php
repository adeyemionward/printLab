
@extends('company.layout.master')
@section('content')
@section('title', 'Job Order')
@php $page = 'view_order' @endphp
<style>
    .question{
        color:red;
        font-weight: bold;
        width: 20% !important;
    }
    th, td {
  padding: 5px;
}
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Job Order</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Job Order</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('company.job_order.job_order_view_inc')

                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">View Job Order</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server" role="tabpanel" aria-labelledby="nav-server-tab">
                                                        <div class="row g-3 ">
                                                            <div class="col-md-12">
                                                                <table width="100%" class="details">
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Job Id :</td>
                                                                        <td>{{ $job_order->id ?? 'N/A' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="10%" class="question">Created By :</td>
                                                                        <td>{{ ($job_order->createdBy->firstname ?? '') . ' ' . ($job_order->createdBy->lastname ?? 'N/A') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="10%" class="question">Created At :</td>
                                                                        <td>{{ $job_order->created_at ?? 'N/A' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="10%" class="question">Updated By :</td>
                                                                        <td>{{ ($job_order->updatedBy->firstname ?? '') . ' ' . ($job_order->updatedBy->lastname ?? 'N/A') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="10%" class="question">Updated At :</td>
                                                                        <td>{{ $job_order->updated_at ?? 'N/A' }}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Customer Name :</td>
                                                                        <td>
                                                                            @if(isset($job_order->user_id))
                                                                                <a style="text-decoration:underline; color:blue" href="{{ route('company.customers.view_customer', $job_order->user_id) }}">
                                                                                    {{ ($job_order->user->firstname ?? '') . ' ' . ($job_order->user->lastname ?? 'N/A') }}
                                                                                </a>
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="10%" class="question">Status :</td>
                                                                        <td>{{ $job_order->status ?? 'N/A' }}</td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Total Cost :</td>
                                                                        <td>
                                                                            @php
                                                                                $order_cost = (float) str_replace(',', '', $job_order->total_cost ?? 0);
                                                                            @endphp
                                                                            &#8358;{{ number_format($order_cost, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="det">
                                                                        <td width="10%" class="question">Current Amount Paid:</td>
                                                                        <td>
                                                                            @php
                                                                                $amount_paid = (float) str_replace(',', '', $job_order_pay->amount ?? 0);
                                                                            @endphp
                                                                            &#8358;{{ number_format($amount_paid, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12 col-xl-12">
                                                            <div class="card">
                                                                <div class="content" id="tableContent">
                                                                    <div class="canvas-wrapper">
                                                                        <table id="example" class="table no-margin" style="width:100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>S/N</th>
                                                                                    <th>Job&nbsp;Type</th>
                                                                                    <th>Unit Cost</th>
                                                                                    <th>Quantity</th>
                                                                                    <th>Ink</th>
                                                                                    <th>Paper&nbsp;Type</th>
                                                                                    <th>Production&nbsp;Days</th>
                                                                                    <th>Cost</th>
                                                                                    <th>Status</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($job_orders as $index => $val)
                                                                                    @php
                                                                                        $job_name = $val->job_order_name ?? 'unknown_job';
                                                                                        $job_title = str_replace(' ', '_', $job_name);
                                                                                        $item_cost = (float) str_replace(',', '', $val->total_cost ?? 0);
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>{{ $index + 1 }}</td>
                                                                                        <td>{{ $job_name }}</td>
                                                                                        <td>&#8358;{{ number_format($val->unit_cost,2 ?? 'N/A') }}</td>
                                                                                        <td>{{ $val->quantity ?? 0 }}</td>
                                                                                        <td>{{ $val->ink ?? 'N/A' }}</td>
                                                                                        <td>{{ $val->paper_type ?? 'N/A' }}</td>
                                                                                        <td>{{ $val->production_days ?? 0 }}</td>
                                                                                        <td>&#8358;{{ number_format($item_cost, 2) }}</td>
                                                                                        <td>{{ $val->status ?? 'N/A' }}</td>
                                                                                        <td>
                                                                                            <a href="{{ route('company.job_order.view_title_order', [$job_title, $val->id]) }}">
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
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
@endsection
