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
                            <label style="padding-bottom:20px"><a href="{{route('product_categories', 'Higher_Education')}}" style="color:#000; ">Higher Education NoteBook</a></label>

                            <label style="padding-bottom:20px"><a href="{{route('product_categories', 'Eighty_Leaves')}}" style="color:#000">80 Leaves NoteBook</a></label>

                            <label style="padding-bottom:20px"><a href="{{route('product_categories', 'Forty_Leaves')}}" style="color:#000">40 Leaves NoteBook</a></label>

                            <label style="padding-bottom:20px"><a href="{{route('product_categories', 'Twenty_Leaves')}}" style="color:#000">20 Leaves NoteBook</a> </label>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8 col-md-8">
                <div class="latest-items latest-items2">
                    <div class="row">
                        {{-- @foreach ($product_higher_education as $val) --}}
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (!is_null($product_higher_education))
                                        @if (request()->title == 'Higher_Education')
                                            @php $product_name = str_replace('_',' ', $product_higher_education->name)   @endphp
                                            <div class="properties-card">
                                                <div class="properties-img">
                                                    @if ( env('APP_ENV') == 'local')
                                                        <a href="{{route('product_details',['Higher_Education',$product_higher_education->id])}}"><img src="{{asset('storage/images/'.$product_higher_education->image)}}" style="height: 320px;" alt></a>
                                                    @else
                                                        <a href="{{route('product_details',['Higher_Education',$product_higher_education->id])}}"><img src="{{asset('public/storage/images/'.$product_higher_education->image)}}" style="height: 320px;" alt></a>
                                                    @endif


                                                </div>
                                                <div class="properties-caption properties-caption2">
                                                    <h3><a href="{{route('product_details',['Higher_Education',$product_higher_education->id])}}">{{ucwords($product_name)}}</a></h3>
                                                    <div class="properties-footer">
                                                        <div class="price">
                                                            <span>&#8358;{{$product_higher_education->productCost->total_cost}} </span> <br>
                                                            <a href="{{route('product_details',['Higher_Education',$product_higher_education->id])}}"><span><button class="btn btn-primary">See Details</button></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>

                    <div class="row">
                        {{-- @foreach ($twenty_leaves as $val) --}}
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (!is_null($twenty_leaves))
                                        @if (request()->title == 'Twenty_Leaves')
                                            @php $product_name = str_replace('_',' ', $twenty_leaves->name)   @endphp
                                            <div class="properties-card">
                                                <div class="properties-img">

                                                    @if ( env('APP_ENV') == 'local')
                                                        <a href="{{route('product_details',['Twenty_Leaves',$twenty_leaves->id])}}"><img src="{{asset('storage/images/'.$twenty_leaves->image)}}" style="height: 320px;" alt></a>
                                                    @else
                                                        <a href="{{route('product_details',['Twenty_Leaves',$twenty_leaves->id])}}"><img src="{{asset('public/storage/images/'.$twenty_leaves->image)}}" style="height: 320px;" alt></a>
                                                    @endif
                                                </div>
                                                <div class="properties-caption properties-caption2">
                                                    <h3><a href="{{route('product_details',['Twenty_Leaves',$twenty_leaves->id])}}">{{ucwords($product_name)}}</a></h3>
                                                    <div class="properties-footer">
                                                        <div class="price">
                                                            <span>&#8358;{{$twenty_leaves->productCost->total_cost}} </span> <br>
                                                            <a href="{{route('product_details',['Twenty_Leaves',$twenty_leaves->id])}}"><span><button class="btn btn-primary">See Details</button></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>

                    <div class="row">
                        {{-- @foreach ($forty_leaves as $val) --}}
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (!is_null($forty_leaves))
                                        @if (request()->title == 'Forty_Leaves')
                                            @php $product_name = str_replace('_',' ', $forty_leaves->name)   @endphp
                                            <div class="properties-card">
                                                <div class="properties-img">
                                                    @if ( env('APP_ENV') == 'local')
                                                        <a href="{{route('product_details',['Forty_Leaves',$forty_leaves->id])}}"><img src="{{asset('storage/images/'.$forty_leaves->image)}}" style="height: 320px;" alt></a>
                                                    @else
                                                        <a href="{{route('product_details',['Forty_Leaves',$forty_leaves->id])}}"><img src="{{asset('public/storage/images/'.$forty_leaves->image)}}" style="height: 320px;" alt></a>
                                                    @endif

                                                </div>
                                                <div class="properties-caption properties-caption2">
                                                    <h3><a href="{{route('product_details',['Forty_Leaves',$forty_leaves->id])}}">{{ucwords($product_name)}}</a></h3>
                                                    <div class="properties-footer">
                                                        <div class="price">
                                                            <span>&#8358;{{$forty_leaves->productCost->total_cost}} </span> <br>
                                                            <a href="{{route('product_details',['Forty_Leaves',$forty_leaves->id])}}"><span><button class="btn btn-primary">See Details</button></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>

                    <div class="row">
                        {{-- @foreach ($eighty_leaves as $val) --}}
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="properties pb-30">
                                    @if (!is_null($eighty_leaves))
                                        @if (request()->title == 'Eighty_Leaves')
                                            @php $product_name = str_replace('_',' ',@$eighty_leaves->name)   @endphp
                                            <div class="properties-card">
                                                <div class="properties-img">

                                                    @if ( env('APP_ENV') == 'local')
                                                        <a href="{{route('product_details',['Eighty_Leaves',$eighty_leaves->id])}}"><img src="{{asset('storage/images/'.$eighty_leaves->image)}}" style="height: 320px;" alt></a>
                                                    @else
                                                        <a href="{{route('product_details',['Eighty_Leaves',$eighty_leaves->id])}}"><img src="{{asset('public/storage/images/'.$eighty_leaves->image)}}" style="height: 320px;" alt></a>
                                                    @endif
                                                </div>
                                                <div class="properties-caption properties-caption2">
                                                    <h3><a href="{{route('product_details',['Eighty_Leaves',$eighty_leaves->id])}}">{{ucwords($product_name)}}</a></h3>
                                                    <div class="properties-footer">
                                                        <div class="price">
                                                            <span>&#8358;{{$eighty_leaves->productCost->total_cost}} </span> <br>
                                                            <a href="{{route('product_details',['Eighty_Leaves',$eighty_leaves->id])}}"><span><button class="btn btn-primary">See Details</button></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
@endsection
