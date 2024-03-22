@extends('layout.landing_master')
@section('content')
@section('title', 'Home')
<style>
    body{
        background: rgb(255, 253, 253)
    }
    .bio-img {
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Adjust the opacity and color as needed */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: #fff; /* Text color */
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bio-img .overlay{
    opacity: 1;
}

.overlay-text {
    font-size: 400px;
    margin-bottom: 5px;
    font-weight: bold;
}

.sub-title {
    font-size: 18px;
    color: green !important
}



</style>
<div class="site-blocks-cover" style="overflow: hidden;">
<div class="container">
<div class="row align-items-center justify-content-center">
<div class="col-md-12" style="position: relative;" data-aos="fade-up" data-aos-delay="200">
<img src="{{asset('front/images/hero_2.jpg')}}" alt="Image" style="margin-top: -60px; height:350px"  class="img-fluid img-absolute">
<div class="row mb-4" data-aos="fade-up" data-aos-delay="200">
<div class="col-lg-6 mr-auto">
<h1>Empowering Your Financial Futures</h1>
<p class="mb-5 lead" style="font-size:22px">Through our innovative daily contribution and cooperative savings solutions, we provide the tools and resources you need to achieve your financial goals.</p>
<div>
<a href="{{route('register')}}" class="btn btn-primary mr-2 mb-2">Get Started</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="site-section" id="features-section" style="margin-top:-150px">
    <div class="container">
        <div class="row  justify-content-center text-center" >
            <div class="col-7 text-center  mb-5">
                <h2 class="section-title">Our Products</h2>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="person">
                    <div class="bio-img">
                        <figure>
                            <img src="{{asset('front/images/daily_savings.jpg')}}" alt="Image" style="height: 350px" class="img-fluid">
                            <div class="overlay">
                                <h2 class="overlay-text" style="font-size: 50px">Daily Savings</h2>
                                <div style="margin-top:50px">
                                    <a href="{{route('register')}}" class="btn btn-primary mr-2 mb-2">Get Started</a>
                                </div>
                            </div>
                        </figure>
                    </div>
                    <p class="lead">Whether you're saving for a rainy day, a dream vacation, or a down payment on a home, Daily Savings makes it easy, convenient, and rewarding.
                        Say hello to a brighter financial future, powered by your daily commitment to financial wellness
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="person">
                    <div class="bio-img">
                        <figure>
                            <img src="{{asset('front/images/coperative_savings.jpg')}}" alt="Image" style="height: 350px" class="img-fluid">
                            <div class="overlay">
                                <h2 class="overlay-text" style="font-size: 50px">Cooperative Savings</h2>
                                <div style="margin-top:50px">
                                    <a href="{{route('register')}}" class="btn btn-primary mr-2 mb-2">Get Started</a>
                                </div>
                            </div>
                        </figure>
                    </div>
                    <p class="lead">Cooperative Savings offers members opportunities for secure, affordable, and inclusive financial services.
                        Through shared responsibility and mutual support, participants can access competitive interest rates,
                        flexible savings options, and financial education.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-light" id="about-section">
<div class="container">
<div class="row mb-5">
<div class="col-12 text-center">
<h2 class="section-title mb-3">Executive Director's Speech During the 3rd Year Anniversary</h2>
</div>
</div>
<div class="row mb-5">
    <div class="col-lg-6" data-aos="fade-right">
        <p class="mb-4 lead">
            My heartfelt well to welcome all guests and members present here today as we are celebrating this year anniversary of our noble society.
        </p>

        <p class="mb-4 lead">
            I thank God almighty who made today a reality in the history of our great society. A society that born out of need to fill a vaccum in our lives and in our communities.
        </p>

        <p class="mb-4 lead">
           Green Purse is not just a cooperative buta a plus to our world. Green Purse is a God's Agenda for all Psalm 23:2-3. A place of financial rest for all.
        </p>

        <p class="mb-4 lead">
            I'm glad to announce the achievement for the past years. We  startted November, 2019 to the glory og God.
         </p>

    </div>
    <div class="col-lg-6 ml-auto pl-lg-5">
       
       
         <p class="mb-4 lead">
            During the past year, we were able to register our name with C.A.C with Rc.No 1659025, and we also put in place our office.
         </p>
         <p class="mb-4 lead">
            Many of our members have enjoined and still enjoying the benefit of loan without interest. And many more to come.
         </p>

         <p class="mb-4 lead">
            Green Purse is designed to cater for today and better your tomorrow without any or less burden on you. With Green Purse, your
            tomorrow without any or less burder on you. With Gren Purse, your future starts rom today. Togetherness and accountability is the
            motor that is driving us.
         </p>

         <p class="mb-4 lead">
            Finally, only yo can go fast, but with togetherness, we can go far.
         </p>

         <p class="mb-4">

         </p>
    </div>


</div>

<div class="row mb-5">
    <div class="col-lg-6 ml-auto pl-lg-5">
        <h2 class="text-black mb-4 h3 font-weight-bold">Our Vision</h2>
        {{-- <p class="mb-4">Eos cumque optio dolores excepturi rerum temporibus magni recusandae eveniet, totam omnis consectetur maxime quibusdam expedita dolorem dolor nobis dicta labore quaerat esse magnam unde, aperiam delectus! At maiores, itaque.</p> --}}
        <ul class="ul-check mb-5 list-unstyled success lead">
        <li>To meet the needs of our membership with no burder</li>
        <li>To ensure the future financial security of our members</li>
        <li>To bring about self sustainability development of our members</li>
        <li>For poverty alleviation in our society</li>
        </ul>
        {{-- <p><a href="{{route('register')}}" class="btn btn-primary">Get Started</a></p> --}}
    </div>
    <div class="col-lg-6 ml-auto pl-lg-5">
        <h2 class="text-black mb-4 h3 font-weight-bold">Our Mission</h2>
        {{-- <p class="mb-4">Eos cumque optio dolores excepturi rerum temporibus magni recusandae eveniet, totam omnis consectetur maxime quibusdam expedita dolorem dolor nobis dicta labore quaerat esse magnam unde, aperiam delectus! At maiores, itaque.</p> --}}
        <ul class="ul-check mb-5 list-unstyled success lead">
        <li>Enhancing the savings culture of our members</li>
        <li>Giving our members of a better tomorrow</li>
        <li>A plus to our world</li>
        <li>Better life for all</li>
        <li>Making our society a better for living</li>
        </ul>
        <p><a href="{{route('register')}}" class="btn btn-primary">Get Started</a></p>
    </div>
</div>
</div>
</div>

    <div class="container">

    </div>
<div class="site-section" id="our-team-section">
<div class="container">
<div class="row mb-5 justify-content-center text-center" data-aos="fade-up">
<div class="col-7 text-center  mb-5">
<h2 class="section-title">Our Team</h2>
<p class="lead">Our team is the heart and soul of our business, who are passionate about helping you succeed</p>
</div>
</div>
<div class="row">

<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
<div class="person">
<div class="bio-img">
<figure>
<img src="{{asset('front/images/person_4.jpg')}}" alt="Image" class="img-fluid">
</figure>

</div>
<h2 class="text-black h1">Nicolas Stainer</h2>
<span class="sub-title d-block mb-3">Financing</span>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum excepturi corporis qui doloribus perspiciatis ipsa modi accusantium repellat.</p>
</div>
</div>
<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
<div class="person">
<div class="bio-img">
<figure>
<img src="{{asset('front/images/person_5.jpg')}}" alt="Image" class="img-fluid">
</figure>

</div>
<h2 class="text-black h1">George Brook</h2>
<span class="sub-title d-block mb-3">Founder</span>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum excepturi corporis qui doloribus perspiciatis ipsa modi accusantium repellat.</p>
</div>
</div>
<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
<div class="person">
<div class="bio-img">
<figure>
<img src="{{asset('front/images/person_6.jpg')}}" alt="Image" class="img-fluid">
</figure>

</div>
<h2 class="text-black h1">Emely Hopson</h2>
<span class="sub-title d-block mb-3">Marketing</span>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum excepturi corporis qui doloribus perspiciatis ipsa modi accusantium repellat.</p>
</div>
</div>
</div>
</div>
</div>
<div class="site-section testimonial-wrap bg-light" id="testimonials-section">
<div class="container">
<div class="row mb-5">
<div class="col-12 text-center">
<h2 class="section-title mb-3">Testimonials</h2>
</div>
</div>
</div>
<div class="slide-one-item home-slider owl-carousel">
<div>
<div class="testimonial">
<figure class="mb-4 d-block align-items-center justify-content-center">
</figure>
<blockquote class="mb-3">
<p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
</blockquote>
<p class="text-black"><strong>John Smith</strong></p>
</div>
</div>
<div>
<div class="testimonial">
<figure class="mb-4 d-block align-items-center justify-content-center">
</figure>
<blockquote class="mb-3">
<p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
</blockquote>
<p class="text-black"><strong>Robert Aguilar</strong></p>
</div>
</div>
<div>
<div class="testimonial">
<figure class="mb-4 d-block align-items-center justify-content-center">
</figure>
<blockquote class="mb-3">
<p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
</blockquote>
<p class="text-black"><strong>Roger Spears</strong></p>
</div>
</div>
<div>
<div class="testimonial">
<figure class="mb-4 d-block align-items-center justify-content-center">
</figure>
<blockquote class="mb-3">
<p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
</blockquote>
<p class="text-black"><strong>Kyle McDonald</strong></p>
</div>
</div>
</div>
</div>

@endsection
