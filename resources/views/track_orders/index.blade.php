@extends('layout.landing_master')
@section('content')
@section('title', 'Add Supplier')

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


<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Color</th>
                            <th scope="col">Paper Type</th>
                            <th scope="col">Thickness</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts as $index => $val)
                        @php $product_name = str_replace('_',' ', @$val->productName->name)   @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{asset('product_images/'.@$val->productName->image)}}" alt />
                                        </div>
                                        <div class="media-body">
                                            <p>{{ucwords($val->job_order_name)}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>{{$val->quantity}}</h5>
                                </td>
                                <td>
                                    <h5>{{$val->ink}} Color</h5>
                                </td>
                                <td>
                                    <h5>{{$val->paper_type}}</h5>
                                </td>
                                <td>
                                    <h5>{{$val->thickness}}</h5>
                                </td>
                                <td>
                                    <h5>{{'₦'.$val->total_cost}}</h5>
                                </td>
                                <td><a class="btn" href="{{route('track_orders.view',$val->id)}}"><span >View Order</span></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="checkout_btn_inner float-right">
                <a class="btn" href="#">Continue Shopping</a>
                <a class="btn checkout_btn" href="#">Proceed to checkout</a>
                </div> --}}
            </div>
        </div>
    </div>
</section>
</main>
@endsection
