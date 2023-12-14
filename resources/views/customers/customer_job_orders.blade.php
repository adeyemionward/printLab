
@extends('layout.master')
@section('content')
@section('title', 'Customer Job Orders')
@php $page = 'orders'; @endphp
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Job Orders for {{$customer->firstname.' '.$customer->lastname}} </h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Customer Job Order</a></li>
                        <li class="breadcrumb-item active">All Orders</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('customers.side_inc')
                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="content" id="tableContent">

                                            <div class="canvas-wrapper">

                                                <table id="example" class="table no-margin" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Customer&nbsp;Name</th>
                                                            <th>Job&nbsp;Type</th>
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
                                                        @php $job_title = str_replace(' ','_', $val->job_order_name)   @endphp
                                                            <tr>
                                                                <td>{{$index+1}}</td>
                                                                <td>{{$val->customer->firstname.' '. $val->customer->lastname}}</td>
                                                                <td>{{$val->job_order_name}}</td>
                                                                <td>{{$val->quantity}}</td>
                                                                <td>{{$val->ink}}</td>
                                                                <td>{{$val->paper_type}}</td>
                                                                <td>{{$val->production_days}}</td>
                                                                <td>{{'₦'.$val->total_cost}} </td>
                                                                <td>{{$val->status}}</td>
                                                                <td><a href="{{route('job_order.view_order',[$job_title, $val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
                                                            </tr>
                                                        @endforeach


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>

                <!-- 							Canvas Wrapper End -->

            </div>
        </div>

    </div>
@endsection

