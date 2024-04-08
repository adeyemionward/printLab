
@extends('layout.master')
@section('content')
@section('title', 'Video Profiling')
@php $page = 'video_profile' @endphp

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Video Profiling</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Video Profiling</li>
                    </ol>
                </div>
            </div>

            <div class="content">
                <div class="canvas-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('job_order.job_order_inc')

                                <div class="col-md-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0 text-muted">Create Video Profiling</h5>
                                        </div>
                                        <div class="card-body h-100">
                                            <div class="align-items-start">
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-server"
                                                        role="tabpanel" aria-labelledby="nav-server-tab">

                                                        <div class="row g-3 mb-3 mt-3">
                                                            <div class="col-md-12">
                                                                <form method="POST"  id="add_twenty_leaves" class="add_twenty_leaves">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <input type="hidden" name="note_type" value="Higher NoteBook" >
                                                                    <div class="row"> 
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="customer_name">Customer Name</label>
                                                                            <select name="customer_id" required class="form-control form-select" id="customer_name">
                                                                                <option >--Select Customer Name--</option>
                                                                                @foreach ($customers as $val)
                                                                                    <option value="{{$val->id}}">{{$val->firstname.' '.$val->lastname }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                     

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlInput1">Quantity </label>
                                                                            <input type="number" required name="quantity" class="form-control"
                                                                                id="quantity">
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="thickness"> Cover Paper</label>
                                                                            <select class="form-control form-select" required  name="cover_paper" id="thickness">
                                                                                <option value="">--Select Cover Paper--</option>
                                                                                <option value="soft_cover">Soft Paper Cover</option>
                                                                                <option value="hard_cover">Hard Paper Cover</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlSelect1">Screen Size</label>
                                                                                <select name="screen_size" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                                    <option value="">--Select Screen Size--</option>
                                                                                    <option value="2.4 Inch TFT Screen">2.4 Inch TFT Screen</option>
                                                                                    <option value="4.3 Inch TFT Screen">4.3 Inch TFT Screen</option>
                                                                                    <option value="5 Inch TFT Screen">5 Inch TFT Screen</option>
                                                                                    <option value="5 Inch IPS Screen">5 Inch IPS Screen</option>
                                                                                    <option value="7 Inch TFT Screen">7 Inch TFT Screen</option>
                                                                                    <option value="7 Inch IPS Screen">7 Inch IPS Screen</option>
                                                                                    <option value="10 Inch TFT Screen">10 Inch TFT Screen</option>
                                                                                    <option value="10 Inch IPS Screen">10 Inch IPS Screen</option>
                                                                                </select>
                                                                        </div>
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="proof_needed">Display Area</label>
                                                                            <select name="display_area" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                                <option value="">--Select Display Area--</option>
                                                                                <option value="48mm*36mm">48mm*36mm</option>
                                                                                <option value="94mm*53mm">94mm*53mm</option>
                                                                                <option value="110mm*61mm">110mm*61mm</option>
                                                                                <option value="107mm*64mm">107mm*64mm</option>
                                                                                <option value="152mm*85mm">152mm*85mm</option>
                                                                                <option value="221mm*124mm">221mm*124mm</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlSelect1">Resolution
                                                                                </label>
                                                                                <select name="resolution" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                                    <option value="">--Select Resolution--</option>
                                                                                    <option value="320*240">320*240</option>
                                                                                    <option value="480*272">480*272</option>
                                                                                    <option value="800*480">800*480</option>
                                                                                    <option value="1024*600">1024*600</option>
                                                                                    <option value="1280*800">1280*800</option>
                                                                                </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">


                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlSelect1">Battery
                                                                                </label>
                                                                                <select name="battery" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                                    <option value="">--Select Battery--</option>
                                                                                    <option value="320~2000mAH">320~2000mAH</option>
                                                                                </select>
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="exampleFormControlSelect1">Memory Information </label>
                                                                                <select name="memory" required class="form-control form-select"  id="exampleFormControlSelect1">
                                                                                    <option value="">--Select Memory Information--</option>
                                                                                    <option value="128M">128M</option>
                                                                                    <option value="256M">256M</option>
                                                                                    <option value="512M">512M</option>
                                                                                    <option value="1GB">1GB</option>
                                                                                    <option value="2GB">2GB</option>
                                                                                    <option value="4GB">4GB</option>
                                                                                </select>
                                                                        </div>



                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="production_time">Production Time (Days)</label>
                                                                            <input required type="number" name="production_time" class="form-control" id="quantity" placeholder="eg: 4">
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="total_cost">Total Cost</label>
                                                                            <input type="number" required name="total_cost" class="form-control"id="total_cost" placeholder="eg: 24000">
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="proof_needed">Payment Type</label>
                                                                            <select class="form-control" name="payment_type" required>
                                                                                <option value="">--Select Payment Type--</option>
                                                                                <option value="Full Payment">Full Payment</option>
                                                                                <option value="Part Payment">Part Payment</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="amount_paid">Amount Paid</label>
                                                                            <input type="number"  name="amount_paid" class="form-control"
                                                                                id="amount_paid" placeholder="eg: 10000" required>
                                                                        </div>
                                                                        <div class="form-group mt-3 mb-3 col-md-4">
                                                                            <label for="location">Job Location</label>
                                                                            <select class="form-control" name="location" required>
                                                                                <option value="">--Select Job Location--</option>
                                                                                @foreach ($locations as $val)
                                                                                    <option value="{{$val->id}}">{{$val->city}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <button class="btn btn-sm btn-danger" type="submit">
                                                                        <i class="text-white me-2" data-feather="check-circle"></i>Create Video Profiling
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <hr/>
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
