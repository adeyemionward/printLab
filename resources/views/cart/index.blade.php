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
<h2>Cart</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('cart.index')}}">Cart</a></li>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @if ($cartCount >= 1)
                        <tbody>
                            @foreach ($carts as $index => $val)
                            @php
                                $product_name = str_replace(' ','_', $val->job_order_name);
                                if($product_name == 'Higher_NoteBook') $product_name = 'Higher_Education';


                            @endphp

                                <tr>
                                    <form method="POST">
                                        @csrf
                                    <input type="hidden" value="{{$val->id}}" name="job_id[]">
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{asset('product_images/'.$val->productName->image)}}" alt />
                                            </div>
                                            <div class="media-body">
                                                <p>{{ucwords($product_name)}}</p>
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

                                    <td><a class="btn" href="{{route('cart.edit', [$product_name, $val->product_id, $val->id])}}"><span >Edit Order</span></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif

                </table>
                @if ($cartCount >= 1)
                    <div class="checkout_btn_inner float-right">
                        <p >NOTE: You will be contacted on delivery processes as soon as we receive your order</p>
                        <a class="btn" href="{{route('index')}}#buy_products">Continue Shopping</a>
                        <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Make&nbsp;Order</button>
                    </div>
                @endif
            </form>
            </div>
        </div>
    </div>
</section>

</main>
@endsection
