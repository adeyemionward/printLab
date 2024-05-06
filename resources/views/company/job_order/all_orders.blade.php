
@extends('company.layout.master')
@section('content')
@section('title', 'All Orders Internal')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Internal Orders</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Job Order</a></li>
                        <li class="breadcrumb-item active">All Orders</li>
                    </ol>
                </div>
            </div>


            <div class="card">

                <div class="content" id="tableContent">

                    <div class="canvas-wrapper">

                        @include('company.includes.date_range')
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Job Type</th>
                                    <th>Quantity</th>
                                    <th>Ink</th>
                                    <th>Paper Type</th>
                                    <th>Production Days</th>
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
                                        <td>{{$val->user->firstname.' '. $val->user->lastname}}</td>
                                        <td>{{$val->job_order_name}}</td>
                                        <td>{{$val->quantity}}</td>
                                        <td>{{$val->ink}}</td>
                                        <td>{{$val->paper_type}}</td>
                                        <td>{{$val->production_days}}</td>
                                        <td>{{'₦'.$val->total_cost}} </td>
                                        <td>{{$val->status}}</td>
                                        <td><a href="{{route('company.job_order.view_order',[$job_title, $val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

