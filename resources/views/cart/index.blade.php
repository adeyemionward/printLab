@extends('layout.landing_master')
@section('content')
@section('title', 'Add Supplier')
<style>
    .underline {
    border-bottom: 1px solid black; /* Adjust color, width, and style as needed */
}



.box {
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    padding: 20px;
    text-align: center;
}

/* Media query for smaller screens */
@media (max-width: 576px) {
    .col {
        width: 100%; /* Full width on smaller screens */
    }


.col {
    width: calc(50% - 10px); /* Two columns per row */
    margin-bottom: 20px; /* Spacing between rows */
}

}
</style>

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


<section class="blog_area">
<div class="container">
<div class="row">
    <div class="col-lg-8 mb-5 mb-lg-0">
        <div class="blog_left_sidebar">
            <article class="blog_item">
                @if ($cartCount >= 1)
                        @forelse ($carts as $index => $val)
                            <div class="blog_details">
                                @php
                                    $product_name = str_replace(' ','_', $val->job_order_name);
                                    if($product_name == 'Higher_NoteBook') $product_name = 'Higher_Education';
                                @endphp
                                <form method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$val->id}}" name="job_id[]">
                                    <div class="media post_item">
                                        {{-- <img src="assets/img/post/post_1.jpg" alt="post" style="width: 120px"> --}}
                                        @if ( env('APP_ENV') == 'local')
                                            <img src="{{asset('storage/images/'.$val->productName->image)}}" alt="product_image" style="width: 125px; height:150px">
                                        @else
                                            <img src="{{asset('public/storage/images/'.$val->productName->image)}}"  alt="product_image" style="width: 125px; height:150px">
                                        @endif
                                        <div class="media-body" style="padding-left: 20px">
                                            <a >
                                                <h3 style="color: #2d2d2d;">{{str_replace('_',' ',ucwords($product_name))}}</h3>
                                            </a>
                                            <div class="row" >
                                                <div class="col-md-3 col">
                                                    <p style="font-size: 20px">Quantity</p>
                                                    <span><input type="number" value="{{$val->quantity}}" class="form-control"></span>
                                                </div>
                                                <div class="col-md-3 col">
                                                    <p style="font-size: 20px">Total</p>
                                                    <span><input type="hidden" class="form-control">{{'₦'.$val->total_cost}}</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <td><a href="{{route('cart.edit', [$val->productName->name, $val->product_id, $val->id])}}"><span >Edit</span></a></td>
                                                </div>
                                                <div class="col-md-3">
                                                    <td><a style="color:red"  onclick="return confirm('Are you sure you want to delete this cart?');" href="{{route('cart.delete', [$val->id])}}"><span >Delete</span></a></td>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 30px">
                                        <h5><strong>Product Specification</strong></h5>
                                        <div class="row">
                                            @if(!is_null($val->ink))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Color</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->ink}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->paper_type))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Paper Type</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->paper_type}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->thickness))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Thickness</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->thickness}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->cover_paper))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Cover Paper</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{str_replace('_',' ',ucwords($val->cover_paper))}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->memory))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Memory</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->memory}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->productName->screen_size))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Screen Size</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->productName->screen_size}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->productName->display_area))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Display Area</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->productName->display_area}}</p>
                                                </div>
                                            @endif

                                            @if(!is_null($val->resolution))
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">Resolution</p>
                                                </div>
                                                <div class="col-md-6 col">
                                                    <p style="font-size: 20px">{{$val->resolution}}</p>
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                <p class="underline"></p>
                            </div>
                        @empty
                        <div class="blog_details">
                            Empty Cart
                        </div>
                        @endforelse
                        <div class="blog_details">
                            @if ($cartCount >= 1)
                            <div class="checkout_btn_inner float-right">
                                <p >NOTE: You will be contacted on delivery processes as soon as we receive your order. Please check your email for more info.</p> 
                                <p >NOTE: 75% of the total amount must be paid before we can process your order.</p> <br>
                                <a class="btn" href="{{route('index')}}#buy_products">Continue Shopping</a>
                                <button href="" type="submit" style="background: black; color:#fff; font-size:20px" class="white-btn">Make&nbsp;Order</button>
                            </div>
                        @endif
                        </div>

                        </form>
                @else
                    <div class="blog_details">
                        <h1> Empty Cart</h1>
                    </div>
                @endif
            </article>
        </div>
    </div>
<div class="col-lg-4">
<div class="blog_right_sidebar">

<aside class="single_sidebar_widget popular_post_widget">
    <h3 class="widget_title" style="color: #2d2d2d;">Trending Products</h3>

    @forelse ($products as $val)
        <div class="media post_item">
            @if ( env('APP_ENV') == 'local')
                <img src="{{asset('storage/images/'.$val->image)}}" alt="product_image" style="width:80px; height:80px">
            @else
                <img src="{{asset('public/storage/images/'.$val->image)}}"  alt="product_image" style="width:80px; height:80px">
            @endif
            {{-- <img src="{{asset('storage/images/'.$val->image)}}" alt="image" style="width:80px; height:80px"> --}}
            <div class="media-body">
                <a href="{{route('product_details',[$val->name,$val->id])}}">
                    <h3 style="color: #2d2d2d;">{{$val->title}}</h3>
                </a>
                <a  href="{{route('product_details',[$val->name,$val->id])}}"  style="color:red" >See Details</a>
            </div>
        </div>
    @empty

    @endforelse

</aside>

</div>
</div>
</div>
</div>
</section>

@endsection
