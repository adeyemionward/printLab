@extends('layout.landing_master')
@section('content')
@section('title', 'Product Categories')

<div class="hero-area section-bg2">
<div class="container">
<div class="row">
<div class="col-xl-12">
<div class="slider-area">
<div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
<div class="hero-caption hero-caption2">
<h2>Category</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
<li class="breadcrumb-item"><a href="#">Category</a></li>
</ol>
</nav>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="listing-area pt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="category-listing mb-50">
                    <div class="single-listing">

                        <div class="select-Categories pb-20">
                            <div class="small-tittle mb-20">
                            <h4>Filter by Produtcs</h4>
                            </div>
                            <label style="padding-bottom:20px"><a href="" style="color:#000; ">Higher Education NoteBook</a></label>

                            <label style="padding-bottom:20px"><a href="" style="color:#000">80 Leaves NoteBook</a></label>

                            <label style="padding-bottom:20px"><a href="" style="color:#000">40 Leaves NoteBook</a></label>

                            <label style="padding-bottom:20px"><a href="" style="color:#000">20 Leaves NoteBook</a> </label>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8 col-md-8">
                <div class="latest-items latest-items2">
                    <div class="row">
                        @foreach ($product_higher_education as $val)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (request()->title == 'Higher_Education')
                                        @php $product_name = str_replace('_',' ', $val->name)   @endphp
                                        <div class="properties-card">
                                            <div class="properties-img">
                                                <a href="{{route('product_details',['Higher_Education',$val->id])}}"><img src="{{asset('storage/images/'.$val->image)}}" style="height: 320px;" alt></a>
                                            </div>
                                            <div class="properties-caption properties-caption2">
                                                <h3><a href="{{route('product_details',['Higher_Education',$val->id])}}">{{ucwords($product_name)}}</a></h3>
                                                <div class="properties-footer">
                                                    <div class="price">
                                                        <span>&#8358;{{$val->productCost->total_cost}} </span> <br>
                                                        <a href="{{route('product_details',['Higher_Education',$val->id])}}"><span><button class="btn btn-primary">Order Now</button></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        @foreach ($twenty_leaves as $val)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (request()->title == 'Twenty_Leaves')
                                        @php $product_name = str_replace('_',' ', $val->name)   @endphp
                                        <div class="properties-card">
                                            <div class="properties-img">
                                                <a href="{{route('product_details',['Twenty_Leaves',$val->id])}}"><img src="{{asset('product_images/'.$val->image)}}" style="height: 320px;" alt></a>
                                            </div>
                                            <div class="properties-caption properties-caption2">
                                                <h3><a href="{{route('product_details',['Twenty_Leaves',$val->id])}}">{{ucwords($product_name)}}</a></h3>
                                                <div class="properties-footer">
                                                    <div class="price">
                                                        <span>&#8358;{{$val->productCost->total_cost}} </span> <br>
                                                        <a href="{{route('product_details',['Twenty_Leaves',$val->id])}}"><span><button class="btn btn-primary">Order Now</button></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        @foreach ($forty_leaves as $val)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (request()->title == 'Forty_Leaves')
                                        @php $product_name = str_replace('_',' ', $val->name)   @endphp
                                        <div class="properties-card">
                                            <div class="properties-img">
                                                <a href="{{route('product_details',['Forty_Leaves',$val->id])}}"><img src="{{asset('product_images/'.$val->image)}}" style="height: 320px;" alt></a>
                                            </div>
                                            <div class="properties-caption properties-caption2">
                                                <h3><a href="{{route('product_details',['Forty_Leaves',$val->id])}}">{{ucwords($product_name)}}</a></h3>
                                                <div class="properties-footer">
                                                    <div class="price">
                                                        <span>&#8358;{{$val->productCost->total_cost}} </span> <br>
                                                        <a href="{{route('product_details',['Forty_Leaves',$val->id])}}"><span><button class="btn btn-primary">Order Now</button></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        @foreach ($eighty_leaves as $val)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (request()->title == 'Eighty_Leaves')
                                        @php $product_name = str_replace('_',' ', $val->name)   @endphp
                                        <div class="properties-card">
                                            <div class="properties-img">
                                                <a href="{{route('product_details',['Eighty_Leaves',$val->id])}}"><img src="{{asset('product_images/'.$val->image)}}" style="height: 320px;" alt></a>
                                            </div>
                                            <div class="properties-caption properties-caption2">
                                                <h3><a href="{{route('product_details',['Eighty_Leaves',$val->id])}}">{{ucwords($product_name)}}</a></h3>
                                                <div class="properties-footer">
                                                    <div class="price">
                                                        <span>&#8358;{{$val->productCost->total_cost}} </span> <br>
                                                        <a href="{{route('product_details',['Eighty_Leaves',$val->id])}}"><span><button class="btn btn-primary">Order Now</button></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
@endsection
