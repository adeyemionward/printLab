@extends('layout.landing_master')
@section('content')
@section('title', 'Contact')

<div class="hero-area section-bg2">
<div class="container">
<div class="row">
<div class="col-xl-12">
<div class="slider-area">
<div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
<div class="hero-caption hero-caption2">
<h2>Contact</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('contact.index')}}">Contact Us</a></li>
</ol>
</nav>
</div>
</div>
</div>
</div>
</div>
</div>
</div>



<section class="contact-section">
<div class="container">
<div class="d-none d-sm-block mb-5 pb-4">

</div>
<div class="row">
<div class="col-12">
<h2 class="contact-title">Get in Touch</h2>
</div>
<div class="col-lg-8">
<form class="form-contact contact_form" id="contactForm" novalidate="novalidate" method="POST">
    @csrf
<div class="row">

<div class="col-sm-6">
<div class="form-group">
<input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name">
</div>
</div>
<div class="col-sm-6">
    <div class="form-group">
    <input class="form-control valid" name="phone" id="phone" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your phone number'" placeholder="Enter your phone number">
    </div>
    </div>
<div class="col-sm-12">
<div class="form-group">
<input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
</div>
</div>
<div class="col-12">
<div class="form-group">
<input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject">
</div>
</div>
<div class="col-12">
    <div class="form-group">
    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message"></textarea>
    </div>
    </div>
</div>
<div class="form-group mt-3">
    {!! NoCaptcha::display() !!}
    {!! NoCaptcha::renderJs() !!}
<button type="submit" id="subBtn" class="button button-contactForm boxed-btn">Send</button>
</div>
</form>
</div>
<div class="col-lg-3 offset-lg-1">
<div class="media contact-info">
<span class="contact-info__icon"><i class="ti-home"></i></span>
<div class="media-body">
<h3>Lagos: 14 Akinremi street,</h3>
<p> Anifowoshe, Ikeja</p> <br>

<h3>Warri: 1 Melcurt Road, off Opeta/Okpaka Road,</h3>
<p>by Ferobas Company, Udu, Warri,</p>
</div>
</div>
<div class="media contact-info">
<span class="contact-info__icon"><i class="ti-tablet"></i></span>
<div class="media-body">
<h3>08035777226</h3>
<p>Mon to Fri 9am to 6pm</p>
</div>
</div>
<div class="media contact-info">
<span class="contact-info__icon"><i class="ti-email"></i></span>
<div class="media-body">
<h3><a href="mail:info@printlabs.com.ng" class="__cf_email__" data-cfemail="a4d7d1d4d4cbd6d0e4c7cbc8cbd6c8cdc68ac7cbc9">info@printlabs.com.ng</a></h3>
<p>Send us your query anytime!</p>
</div>
</div>
</div>
</div>
</div>
</section>

</main>
@endsection
