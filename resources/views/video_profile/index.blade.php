@extends('layout.landing_master')
@section('content')
@section('title', 'Add Supplier')
<style>
@media screen and (min-width: 768px) {
    .hero1{
        margin-top: -150px;
    }

    .more_service{
        margin-top:-80px;
    }
}
@media screen and (max-width: 768px) {

  .hero-caption{
    margin-top: 50px;
  }


  .hero1{
    margin-top: 60px;
  }


  .latest-items{
    position: relative;
    top: 80px;
  }
  #popular_product_text{
    padding-left:30px;
    margin-top: 150px;
    font-weight: bolder;
  }
}
a.contact_now {
    background:transparent;
    padding:20px 40px 20px 40px;
    font-size:25px;
    margin-bottom:30px;
    border:2px solid #FF2020;
}

a span{
    color:red;
}

a.contact_now:hover {
    background-color: #e74c3c;
    color:#fff;

}
a span:hover{
    color:#fff;
}
</style>
<section class="hero1" >
<div class="">

<div class=" slider-height d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6  col-sm-12">
                <video width="500" height="350" controls>
                    <source src="{{asset('video/video_profile_1.mp4')}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6  col-sm-12">
                <video width="500" height="350" controls>
                    <source src="{{asset('video/video_profile_2.mp4')}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

</div>
</section>


</div>
</div>


<div class="latest-items section-padding fix" style="margin-top:-200px">
    <div class="container">
    <div class="row justify-content-between">
    <div class="col-xl-12">
    <div class="nav-button">

    <nav>
    <div class="nav-tittle" id="buy_products" >
    <h2 id="popular_product_text">Popular Video Profiling</h2>
    </div>

    </nav>

    </div>
    </div>
    </div>
    </div>
    <div class="container" >
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
                <div class="latest-items-active">
                    @foreach ($video_profiling as $val)
                    <div class="properties pb-30">
                        <div class="properties-card">
                            <div class="properties-img">
                                @if ( env('APP_ENV') == 'local')
                                    <img src="{{asset('storage/images/'.$val->image)}}" alt="product_image" style="width: 100%; height: 320px;">
                                @else
                                    <img src="{{asset('public/storage/images/'.$val->image)}}"  alt="product_image" style="width: 100%; height: 320px;">
                                @endif
                            </div>
                            <div class="properties-caption properties-caption2">
                                <h3><a href="{{route('product_details',[$val->name,$val->id])}}">{{$val->title}}</a></h3>
                                <div class="properties-footer">
                                    <div class="price">
                                        <a href="{{route('product_details',[$val->name,$val->id])}}"><span><button class="btn btn-primary">Order Now</button></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
                </div>
            </div>
        </div>
    </div>



    </div>
    </div>
    </div>

<section class="more_service"  >

    <div class="container">

        <div class="col-xl-12" style="display: flex;
        justify-content: center;
        align-items: center;
        height: 20vh;
        ">
            <div class="row">

                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8  col-sm-10">

                    <h2 data-animation="bounceIn" data-delay="0.2s" style=" color:#000; font-weight:300">Contact us for other printing service & corporate video profile</h2>

                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4  col-sm-10">

                    {{-- <h2 data-animation="bounceIn" data-delay="0.2s" style=" color:#000;">Contact us for other printing service</h2> --}}
                    <a class="btn_1 hero-btn contact_now"  href="{{route('contact.index')}}" > <span>Contact now</span></a>

                </div>
            </div>

        </div>
    </div>

    </section>

<div class="testimonial-area testimonial-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-10 col-md-11">
                <div class="h1-testimonial-active">
                    @forelse ($all_testimonial as $val)
                        <div class="single-testimonial text-center">
                            <div class="testimonial-caption ">
                                <div class="testimonial-top-cap">
                                    <h2>Customer Testimonial</h2>
                                    <p>{{$val->description}}</p>
                                </div>



                                    <div class="testimonial-founder d-flex align-items-center justify-content-center">
                                    <div class="founder-img">

                                    @if ( env('APP_ENV') == 'local')
                                        <img src="{{asset('storage/images/'.$val->image)}}" alt style="height: 100px; width:100px; border-radius:50%">
                                    @else
                                        <img src="{{asset('public/storage/images/'.$val->image)}}"  alt="customer_image" style="height: 100px; width:100px; border-radius:50%">
                                    @endif
                                    </div>
                                    <div class="founder-text">
                                        <span>{{$val->customer->firstname.' '.$val->customer->lastname}}</span>
                                    {{-- <p>Designer at Colorlib</p> --}}
                                    </div>
                                    </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

</main>
@endsection
