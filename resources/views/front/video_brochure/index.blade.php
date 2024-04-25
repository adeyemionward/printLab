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
/* Hide default radio button */
input[type="radio"] {
  display: none;
}

/* Style the label to create a custom radio button */
label {
  display: inline-block;
  cursor: pointer;
  position: relative;
  padding-left: 30px; /* Adjust based on your preferred size */
}

/* Style the custom radio button */
label::before {
  content: '';
  display: inline-block;
  width: 20px; /* Adjust based on your preferred size */
  height: 20px; /* Adjust based on your preferred size */
  border: 2px solid #ccc; /* Border color */
  border-radius: 50%; /* Rounded shape */
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
}

/* Style the custom radio button when it's checked */
input[type="radio"]:checked + label::before {
  background-color: #007bff; /* Change to your desired color */
}

/* Optional: Style the label text */
label {
  font-size: 16px; /* Adjust based on your preference */
  margin-right: 10px; /* Add spacing between the button and text */
}
.latest-items .properties .properties-card{background-color:#fff}.latest-items .properties .properties-card .properties-img{position:relative;overflow:hidden}.latest-items .properties .properties-card .properties-img img{-webkit-transition:all .4s ease-out 0s;-moz-transition:all .4s ease-out 0s;-ms-transition:all .4s ease-out 0s;-o-transition:all .4s ease-out 0s;transition:all .4s ease-out 0s;width:100%;transform:scale(1)}.latest-items .properties .properties-card .properties-img .socal_icon{-webkit-transition:all .2s ease-out 0s;-moz-transition:all .2s ease-out 0s;-ms-transition:all .2s ease-out 0s;-o-transition:all .2s ease-out 0s;transition:all .2s ease-out 0s;position:absolute;left:0;right:0;margin:0 auto;opacity:0;visibility:hidden;bottom:20px;text-align:center}.latest-items .properties .properties-card .properties-img .socal_icon a{-webkit-transition:all .5s ease-out 0s;-moz-transition:all .5s ease-out 0s;-ms-transition:all .5s ease-out 0s;-o-transition:all .5s ease-out 0s;transition:all .5s ease-out 0s;background:#fff;color:#292621;width:64px;height:50px;display:inline-block;font-size:24px;text-align:center;line-height:54px;margin:-3px}.latest-items .properties .properties-card .properties-img .socal_icon a:hover{background:#FF2020;color:#fff}.latest-items .properties .properties-card .properties-caption{padding:14px 20px 2px 0px;-webkit-transition:all .4s ease-out 0s;-moz-transition:all .4s ease-out 0s;-ms-transition:all .4s ease-out 0s;-o-transition:all .4s ease-out 0s;transition:all .4s ease-out 0s}.latest-items .properties .properties-card .properties-caption h3 a{color:#292621;font-size:16px;font-weight:400;margin-bottom:6px}.latest-items .properties .properties-card .properties-caption .properties-footer{-webkit-transition:all .4s ease-out 0s;-moz-transition:all .4s ease-out 0s;-ms-transition:all .4s ease-out 0s;-o-transition:all .4s ease-out 0s;transition:all .4s ease-out 0s}@media (max-width: 575px){.latest-items .properties .properties-card .properties-caption .properties-footer{padding:19px 10px 20px 12px}}.latest-items .properties .properties-card .properties-caption .properties-footer .price span{color:#74706B;cursor:pointer;font-weight:500;font-size:16px}.latest-items .properties .properties-card .properties-caption .properties-footer .price span span{display:inline-block;color:#CEBD9C;text-decoration:line-through;margin:0;margin-left:12px}
</style>
<style>

</style>
<section class="hero1" >
<div class="">

<div class=" slider-height d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                @if (env('APP_ENV') == 'local')
                <video height="350" width="100%" controls>
                    <source src="{{ asset('video/video_profile_1.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @else
                <video height="350" width="100%" controls>
                    <source src="{{ asset('public/video/video_profile_1.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @endif
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                @if (env('APP_ENV') == 'local')
                <video height="350" width="100%" controls>
                    <source src="{{ asset('video/video_profile_2.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @else
                <video height="350" width="100%" controls>
                    <source src="{{ asset('public/video/video_profile_2.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @endif
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
    <h2 id="popular_product_text">Popular Video Brochure</h2>
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
                    @forelse ($video_brochure as $val)
                        <div class="properties pb-30">
                            <div class="properties-card">
                                <div class="properties-img">
                                    <a href="{{route('product_categories','Higher_Education')}}">
                                        @if ( env('APP_ENV') == 'local')
                                            <img src="{{asset('storage/images/'.$val->image)}}" style="height: 320px;" alt="product_image">
                                        @else
                                            <img src="{{asset('public/storage/images/'.$val->image)}}" style="height: 320px;" alt="product_image">
                                        @endif

                                    </a>

                                </div>
                                <div class="properties-caption properties-caption2">
                                    <h3><a href="{{route('product_categories','Higher_Education')}}">{{$val->title}}</a></h3>
                                    <div class="properties-footer">
                                        <div class="price">
                                            <a href="{{route('product_details',[$val->name,$val->id])}}"><span><button class="btn btn-primary">Order Now</button></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse


                </div>
            </div>
        </div>
        {{-- <input type="radio" id="radio1" value="soft_cover" name="coverType" checked>
        <label for="radio1"> Soft Cover Paper</label>

        <input type="radio" id="radio2" value="hard_cover" name="coverType">
        <label for="radio2"> Hard Cover Paper</label>
        <br><br> --}}
        {{-- <div id="ajaxContent" class="row">
            <div id="loadingSpinner" class="text-center mt-5" >
                <i class="fas fa-spinner fa-spin fa-3x"></i>
              </div>
        </div>
        <div id="loadingSpinner1" class="text-center mt-5" style="display:none">
            <i class="fas fa-spinner fa-spin fa-3x"></i>
          </div> --}}

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
                        <div class="single-testimonial text-center" >
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

<script src="{{asset('assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script>



</script>

</main>
@endsection

