
@extends('layout.master')
@section('content')
@section('title', 'All Customer')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Orders</h4>
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
                        <div class="row g-3 mb-3 mt-3">
                            <div class="col-md-12">
                                <form method="GET"  id="" class="">
                                    @csrf
                                    @method('GET')
                                    <div class="row">

                                        <div class="form-group mt-3 mb-3 col-md-4">
                                            <label for="exampleFormControlInput1"> Date From: </label>
                                            <input type="date" required name="date_from" class="form-control {{ $errors->has('date_from') ? ' is-invalid' : '' }} " value="{{request()->date_from}}"  id="date_from">
                                            @error('date_from')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3 mb-3 col-md-4">
                                            <label for="exampleFormControlInput1"> Date To: </label>
                                            <input type="date" required name="date_to" class="form-control {{ $errors->has('date_to') ? ' is-invalid' : '' }} " value="{{request()->date_to}}"  id="date_to">
                                            @error('date_to')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3 mb-3 col-md-4">
                                            <label for=""> Filter </label> <br>
                                            {{-- <input type="submit"  name="expense_date" class="form-control tn btn-sm btn-danger"  id="search"> --}}
                                            <button class="btn btn-sm btn-danger" type="submit" style="width: 200px">
                                                <i class="text-white me-2" data-feather="check-circle"></i>Search
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

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
                                        <td><a href="{{route('job_order.view_order',[$job_title, $val->id])}}"><span><i class="fa fa-eye"></i></span></a></td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

