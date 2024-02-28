
@extends('admin.layout.master')
@section('content')
@section('title', 'Dashboard')
    {{-- MAIN BODY CONTENT --}}
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Dashboard</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="teal data-feather-big" stroke-width="3"
                                            data-feather="shopping-cart" style="color: #df4226;"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">All Orders</p>
                                        <span class="number">{{$all_orders}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="d-flex justify-content-between box-font-small">
                                    <div class="col-md-6 stats">
                                        <i data-feather="calendar"></i>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="text-primary float-end" href=""><i
                                            class="blue" data-feather="chevrons-right"></i>See Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="teal data-feather-big" stroke-width="3"
                                            data-feather="shopping-cart" style="color:rgb(31, 121, 31);"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">New Orders</p>
                                        <span class="number">{{$pending_orders}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="d-flex justify-content-between box-font-small">
                                    <div class="col-md-6 stats">
                                        <i data-feather="calendar"></i>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="text-primary float-end" href=""><i
                                            class="blue" data-feather="chevrons-right"></i>See Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="orange data-feather-big" stroke-width="3"
                                            data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">Delivered Jobs</p>
                                        <span class="number">{{$delivered_orders}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="d-flex justify-content-between box-font-small">
                                    <div class="col-md-6 stats">
                                        <i data-feather="mail"></i>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="text-primary float-end" href=""><i
                                            class="blue" data-feather="chevrons-right"></i>See Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="olive data-feather-big" stroke-width="3"
                                            data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">Revenue</p>
                                        <span class="number">₦{{number_format($total_cost)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr />
                                <div class="d-flex justify-content-between box-font-small">
                                    <div class="col-md-6 stats">
                                        <i data-feather="calendar"></i>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="text-primary float-end" href="#"><i
                                            class="blue" data-feather="chevrons-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Top Job Orders</h5>
                                    </div>
                                    <div class="canvas-wrapper">
                                        <table class="table no-margin">
                                            <thead class="success">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Jobs</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($top_job_orders as $val)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$val->job_order_name}}</td>
                                                        <td class="text-right">{{$val->total_orders}}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Top Orders By Date</h5>
                                        <p class="text-muted">Today's job order</p>
                                        <form  action="{{ route('admin.dashboard') }}" method="get">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="from_date">From Date:</label>
                                                        <input type="date" name="date_from" class="form-control" value="{{request()->date_from}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="to_date">To Date:</label>
                                                        <input type="date" name="date_to" class="form-control" value="{{request()->date_to}}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Search</label>
                                                        <button type="submit" class="btn" style="color:white; background:gray; padding:3px 20px 3px 20px; ">Search</button>
                                                        {{-- <button class="btn"><a href="{{route('dashboard')}}" style=" text-decoration: underline; color:rgb(5, 15, 64); padding:3px 20px 3px 20px">Clear</a> --}}
                                                    </div>

                                                    <div class="col-md-2">
                                                        {{-- <button type="submit" class="btn " style=" text-decoration: underline; color:green; padding:3px 20px 3px 20px">Search Sales</button> --}}
                                                        <button class="btn"><a href="{{route('admin.dashboard')}}" style=" text-decoration: underline; color:rgb(5, 15, 64); padding:3px 20px 3px 20px">Clear</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="canvas-wrapper">
                                        <table class="table no-margin">
                                            <thead class="success">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Jobs</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty(request()->date_from) && !empty(request()->date_to))
                                                    @foreach ($previous_orders as $val)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$val->job_order_name}}</td>
                                                            <td class="text-right">{{$val->total_orders}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach ($today_orders as $val)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$val->job_order_name}}</td>
                                                            <td class="text-right">{{$val->total_orders}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="ui hidden divider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

