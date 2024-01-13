@extends('layout.landing_master')
@section('content')
@section('title', 'View & Track Order')

<style>
    .question{
        color:red;
        font-weight: bold;
        width: 20% !important;
    }
    th, td {
        padding: 5px;
    }

    .track_title{
        color: green;
        font-size:16px;
        font-weight:bold
    }
    .track_title_no{
        color: gray;
        font-size:16px;
        font-weight:bold
    }

</style>

<div class="hero-area section-bg2">
<div class="container">
<div class="row">
<div class="col-xl-12">
<div class="slider-area">
<div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
<div class="hero-caption hero-caption2">
<h2>Track Orders</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="#">Track Orders</a></li>
</ol>
</nav>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<section class="checkout_area">
    <div class="container">



    <div class="billing_details">
    <div class="row">
        <div class="col-lg-4">
            <div class="order_box">
            <h2>Your Product Order

                       </h2>
            <ul class="list">
                <li>
                    @php $product_name = str_replace('_',' ', $order->productName->name)   @endphp
                    <a href="#">Product<span>{{ucwords($product_name)}}</span>
                    </a>
                </li>
                <li>
                    <a href="#">Color
                        <span class="last">{{$order->ink}} Color</span>
                    </a>
                </li>
                <li>
                    <a href="#">Paper Type
                        <span class="last">{{$order->paper_type}}</span>
                    </a>
                </li>
                <li>
                    <a href="#">Thickness
                        <span class="last">{{$order->thickness}}</span>
                    </a>
                </li>
            </ul>

            <ul class="list list_2">
                <li>
                    <a href="#">Quantity <span>{{$order->quantity}}</span></a>
                </li>
                <li>
                    <a href="#">Total Cost
                        <span>&#8358;{{$order->total_cost}}</span>
                    </a>
                </li>
            </ul>

            @if (!is_null($approved_design))
                <ul class="list list_2">
                    <li>
                        {{-- <a href="#">Quantity <span>{{$order->quantity}}</span></a> --}}
                        <div class="form-group col-md-12">

                            @if ( env('APP_ENV') == 'local')
                            <a  href="{{asset('storage/pdf/'.@$approved_design->design_name)}}" target="_blank" style="width: 100%; text-decoration:underline; font-weight:bold"> <i   class="fas fa-file-pdf"   style="color: red; font-size:30px"> </i> Download an Approved PDF Design </a>
                            @else
                                <a href="{{asset('public/storage/pdf/'.@$approved_design->design_name)}}" target="_blank" style="width: 100%; text-decoration:underline; font-weight:bold"> <i  class="fas fa-file-pdf"     style="color: red; font-size:30px;"> </i>   Download an Approved PDF Design</a>
                            @endif
                        </div>
                    </li>
                </ul>
            @endif
            <br><br>
            <ul class="list list_2">
                <li>
                    {{-- <a href="#">Quantity <span>{{$order->quantity}}</span></a> --}}
                    <div class="form-group col-md-12">

                        <a  href="{{route('track_orders.order_invoice_pdf',$order->order_no)}}" target="_blank" style="width: 100%; text-decoration:underline; font-weight:bold"> <i   class="fas fa-file-pdf"   style="color: red; font-size:30px"> </i> Download Invoice </a>

                    </div>
                </li>
            </ul>
            {{-- <i   class="fas fa-file-pdf"  style="color: red; font-size:30px;"> </i> <a href="{{route('job_order.order_invoice_pdf',request()->id)}}" target="_blank" style="width: 100%; text-decoration:underline; font-weight:bold"> Download Order Invoice </a> --}}



            </div>
            </div>
    <div class="col-lg-8">
    <h3>Track Your Order</h3>

    <form class="row contact_form" action="#" method="post" novalidate="novalidate">
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->pending_status != null)
                <span class="track_title">Created</span>
                <p>{{$job_order_track->pending_date}}</p>
            @else
                <span class="track_title_no">Created</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->designed_status != null)
                <span class="track_title"> Designed</span>
                <p>{{$job_order_track->designed_date}}</p>
            @else
                <span class="track_title_no">Designed</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->customer_approved_status != null)
                <span class="track_title">Customer Approved</span>
                <p>{{$job_order_track->customer_approved_date}}</p>
            @else
                <span class="track_title_no">Customer Approved</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->prepressed_status != null)
                <span class="track_title">Prepressed</span>
                <p>{{$job_order_track->prepressed_date}}</p>
            @else
                <span class="track_title_no">Prepressed</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->printed_status != null)
                <span class="track_title">Printed</span>
                <p>{{$job_order_track->printed_date}}</p>
            @else
                <span class="track_title_no">Printed</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->binded_status != null)
                <span class="track_title">Binded</span>
                <p>{{$job_order_track->binded_date}}</p>
            @else
                <span class="track_title_no">Binded</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->completed_status != null)
                <span class="track_title">Completed</span>
                <p>{{$job_order_track->completed_date}}</p>
            @else
                <span class="track_title_no">Completed</span>
                <p>None</p>
            @endif
        </div>
        <div class="col-md-3 form-group p_star">
            @if ($job_order_track->delivered_status != null)
                <span class="track_title">Delivered</span>
            <p>{{$job_order_track->delivered_date}}</p>
            @else
                <span class="track_title_no">Delivered</span>
                <p>None</p>
            @endif
        </div>
    </form>
    </div>

    </div>
    </div>
    </div>
    </section>



</main>
@endsection
