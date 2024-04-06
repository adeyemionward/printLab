
@extends('layout.master')
@section('content')
@section('title', 'All Internal Profiling Orders')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Internal Profiling Orders</h4>
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

                        @include('includes.date_range')
                        <table id="example" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Customer Name</th>
                                    <th>Quantity</th>
                                    <th>Cover Paper</th>
                                    <th>Screen Size</th>
                                    <th>Display Area</th>
                                    <th>Resolution</th>
                                    <th>Battery</th>
                                    <th>Production Days</th>
                                    <th>Cost</th>
                                    <th>Payment Type</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($internal_video_profilig as $index => $val)

                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$val->user->firstname.' '. $val->user->lastname}}</td>
                                        <td>{{$val->quantity}}</td>
                                        <td>{{$val->cover_paper}}</td>
                                        <td>{{$val->screen_size}}</td>
                                        <td>{{$val->display_area}}</td>
                                        <td>{{$val->resolution}}</td>
                                        <td>{{$val->battery}}</td>
                                        <td>{{$val->production_days}}</td>
                                        <td>{{'₦'.$val->total_cost}} </td>
                                        <td>{{$val->payment_type}}</td>
                                        <td>{{$val->location->state}}</td>
                                        {{-- <td>{{$val->status}}</td> --}}
                                        <td><a href=""><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

