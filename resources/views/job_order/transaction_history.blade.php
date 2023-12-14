
@extends('layout.master')
@section('content')
@section('title', 'Dashboard')
@php $page = 'transaction' @endphp
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
                                @include('job_order.job_order_view_inc')

                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="content" id="tableContent">

                                            <div class="canvas-wrapper">

                                                <table id="example" class="table no-margin" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Payment Type</th>
                                                            <th>Amount</th>
                                                            <th>Payment Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($job_pay_history as  $val)
                                                        {{-- @php $job_title = str_replace(' ','_', $val->job_order_name)   @endphp --}}
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                {{-- <td>{{$val->customer->firstname.' '. $val->customer->lastname}}</td> --}}
                                                                <td>{{$val->payment_type}}</td>
                                                                <td>&#8358;{{$val->amount}}</td>
                                                                <td>{{date('D M d, Y', strtotime($val->payment_date))}}</td>
                                                                {{-- <td><a href="{{route('job_order.view_order',[$job_title, $val->id])}}"><span><i class="fa fa-eye"></i></span></a></td> --}}
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


            </div>

        </div>

    </div>
@endsection
