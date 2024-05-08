@extends('layout.master')
@section('content')
@section('title', 'Subscription')

<div class="hero-area section-bg2">
<div class="container">
<div class="row">
<div class="col-xl-12">
<div class="slider-area">
<div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
<div class="hero-caption hero-caption2">
<h2>Subscription</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('contact.index')}}">Subscription</a></li>
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
<h2 class="contact-title">Choose Your Subscription Plan</h2>
</div>
<div class="col-lg-8">
<form class="form-contact contact_form" id="subscription"  method="POST">
    @csrf
<div class="row">
<input type="hidden" name="email" value="{{$email ?? ''}}">
<input type="hidden" name="company_name" value="{{$name ?? ''}}">
<div class="col-sm-12">
<div class="form-group">
    <select required class="form-control form-select valid" name="payment_plan" id="" style="font-size: 18px">
        <option value="">Select Payment Plan</option>
        <option value="Quarterly">Quarterly (#40,000)</option>
        <option value="Bi-Annual">Bi-annually (#80,000)</option>
        <option value="Annual">Annual (#150,000)</option>
    </select>
</div>
</div>
<div class="col-sm-12">
    <div class="form-group">
        <select required class="form-control form-select valid" name="payment_mode" id="" style="font-size: 18px">
            <option value="">Select Payment Mode</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Paystack" disabled>Paystack</option>
        </select>
    </div>
</div>

</div>
<div class="form-group mt-3">
    {{-- {!! NoCaptcha::display() !!}
    {!! NoCaptcha::renderJs() !!} --}}
<button type="submit" id="subBtn" class="button button-contactForm boxed-btn">Continue</button>
</div>
</form>
</div>
<div class="col-lg-3 offset-lg-1">
<div class="media contact-info">
<span class="contact-info__icon"><i class="ti-home"></i></span>
<div class="media-body">
@foreach ($banks as $bank)
        
<h3>Bank Name: <b>{{$bank->bank_name ?? 'None'}} </b> </h3> <br>
<h3> Bank Acount: <b>{{$bank->account_no ?? 'None'}} </b></h3> <br>
<h3> Bank Acount Name: <b> {{$bank->account_name ?? 'None'}} </b></h3> <br>
@endforeach

</div>
</div>


</div>
</div>
</div>
</section>

</main>
@endsection
