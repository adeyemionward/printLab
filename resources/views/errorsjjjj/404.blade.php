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
<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12  col-sm-10">
<div class="hero-caption text-center">
<h1 data-animation="bounceIn" data-delay="0.2s" style=" color:#000; font-size:45px">Order Your Customized School Notebooks, Corporate Video Profile & Marketing Brochures Here</h1>
<p data-animation="fadeInUp" data-delay="0.4s" style=" color:#fff">A digital printing hub for high quality services and customer satisfaction.</p>
<a href="#buy_products" style="background-color: #FF2020; border-color: transparent; padding:25px 50px 25px 50px; font-size:25px; margin-top:-80px" class="btn_1 hero-btn shop_now" data-animation="fadeInUp" data-delay="0.7s" style="margin-bottom:-2000px; margin-top:-80px">Shop Now</a>
</div>
</div>
</div>
</div>
</div>

</div>
</section>


</div>
</div>


</main>
@endsection
