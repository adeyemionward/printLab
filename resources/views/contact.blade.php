@extends('layout.landing_master')
@section('content')
@section('title', 'Home')

<div class="site-section bg-image2 overlay"  id="contact-section" style="background-image: url({{asset('front/images/about_us.jpg')}});">
    <div class="container" style="margin-top: 60px">
    
    <div class="row justify-content-center">
    <div class="col-lg-7 mb-5">
    <form action="#" class="p-5 bg-white">
    <h2 class="h4 text-black mb-5" style="font-weight:bolder">Contact Form</h2>
    <div class="row form-group">
    <div class="col-md-6 mb-3 mb-md-0">
    <label class="text-black" for="fname">First Name</label>
    <input type="text" id="fname" class="form-control rounded-0">
    </div>
    <div class="col-md-6">
    <label class="text-black" for="lname">Last Name</label>
    <input type="text" id="lname" class="form-control rounded-0">
    </div>
    </div>
    <div class="row form-group">
    <div class="col-md-12">
    <label class="text-black" for="email">Email</label>
    <input type="email" id="email" class="form-control rounded-0">
    </div>
    </div>
    <div class="row form-group">
    <div class="col-md-12">
    <label class="text-black" for="subject">Subject</label>
    <input type="subject" id="subject" class="form-control rounded-0">
    </div>
    </div>
    <div class="row form-group">
    <div class="col-md-12">
    <label class="text-black" for="message">Message</label>
    <textarea name="message" id="message" cols="20" rows="4" class="form-control rounded-0" placeholder="Leave your message here..."></textarea>
    </div>
    </div>
    <div class="row form-group">
    <div class="col-md-12">
    <input type="submit" value="Send Message" class="btn btn-primary mr-2 mb-2">
    </div>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    @endsection
