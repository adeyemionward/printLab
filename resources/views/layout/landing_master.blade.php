<!DOCTYPE html>
<html lang="en">


<head>
<title>Green Purse Limited | A credit and Cooperative Society</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="{{asset('front/fonts/icomoon/style.css')}}">
<link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('front/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('front/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('front/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('front/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('front/css/jquery.fancybox.min.css')}}">
<link rel="stylesheet" href="{{asset('front/css/bootstrap-datepicker.css')}}">
<link rel="stylesheet" href="{{asset('front/fonts/flaticon/font/flaticon.css')}}">
<link rel="stylesheet" href="{{asset('front/css/aos.css')}}">
<link rel="stylesheet" href="{{asset('front/css/style.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script nonce="16881a12-71e0-4237-978a-d2ceec6718cd">try{(function(w,d){!function(du,dv,dw,dx){du[dw]=du[dw]||{};du[dw].executed=[];du.zaraz={deferred:[],listeners:[]};du.zaraz.q=[];du.zaraz._f=function(dy){return async function(){var dz=Array.prototype.slice.call(arguments);du.zaraz.q.push({m:dy,a:dz})}};for(const dA of["track","set","debug"])du.zaraz[dA]=du.zaraz._f(dA);du.zaraz.init=()=>{var dB=dv.getElementsByTagName(dx)[0],dC=dv.createElement(dx),dD=dv.getElementsByTagName("title")[0];dD&&(du[dw].t=dv.getElementsByTagName("title")[0].text);du[dw].x=Math.random();du[dw].w=du.screen.width;du[dw].h=du.screen.height;du[dw].j=du.innerHeight;du[dw].e=du.innerWidth;du[dw].l=du.location.href;du[dw].r=dv.referrer;du[dw].k=du.screen.colorDepth;du[dw].n=dv.characterSet;du[dw].o=(new Date).getTimezoneOffset();if(du.dataLayer)for(const dH of Object.entries(Object.entries(dataLayer).reduce(((dI,dJ)=>({...dI[1],...dJ[1]})),{})))zaraz.set(dH[0],dH[1],{scope:"page"});du[dw].q=[];for(;du.zaraz.q.length;){const dK=du.zaraz.q.shift();du[dw].q.push(dK)}dC.defer=!0;for(const dL of[localStorage,sessionStorage])Object.keys(dL||{}).filter((dN=>dN.startsWith("_zaraz_"))).forEach((dM=>{try{du[dw]["z_"+dM.slice(7)]=JSON.parse(dL.getItem(dM))}catch{du[dw]["z_"+dM.slice(7)]=dL.getItem(dM)}}));dC.referrerPolicy="origin";dC.src="../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(du[dw])));dB.parentNode.insertBefore(dC,dB)};["complete","interactive"].includes(dv.readyState)?zaraz.init():du.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<div id="overlayer"></div>
<div class="loader">
<div class="spinner-border text-primary" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
<div class="site-wrap" id="home-section">
<div class="site-mobile-menu site-navbar-target">
<div class="site-mobile-menu-header">
<div class="site-mobile-menu-close mt-3">
<span class="icon-close2 js-menu-toggle"></span>
</div>
</div>
<div class="site-mobile-menu-body"></div>
</div>
<style>
    .nav-link{
        font-size:18px;
    }
</style>
<header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">
<div class="container">
<div class="row align-items-center">
<div class="col-6 col-md-3 col-xl-3  d-block">
<h1 class="mb-0 site-logo"><a href="index-2.html" class="text-black h2 mb-0">GreenPurse<span class="text-success">.</span> </a></h1>
</div>
<div class="col-12 col-md-9 col-xl-9 main-menu">
<nav class="site-navigation position-relative text-right" role="navigation">
<ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block ml-0 pl-0">
<li><a href="#home-section" class="nav-link">Home</a></li>
<li><a href="#features-section" class="nav-link">Products</a></li>
<li>
    <a href="#about-section" class="nav-link">About Us</a>
</li>
<li><a href="#testimonials-section" class="nav-link">Testimonials</a></li>
<li><a href="contact" class="nav-link">Contact</a></li>

<li><a href="{{route('login')}}" class="nav-link">Login</a></li>
<li><a href="{{route('register')}}" class="nav-link btn btn-primary" style="color: #fff; ">Get Started</a></li>
</ul>
</nav>
</div>
<div class="col-6 col-md-9 d-inline-block d-lg-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle text-black float-right"><span class="icon-menu h3"></span></a></div>
</div>
</div>
<style>
    .btn.btn-primary{
        background-color: green;
        border-color: transparent;
    }

    .btn.btn-primary:hover{
        background-color: rgb(26, 200, 26);
        border-color: transparent;
    }
</style>
</header>
    @yield('content')


    <div class="footer py-5 text-center">
        <div class="container">
        {{-- <div class="row mb-5">
        <div class="col-12">
        <p class="mb-0">
        <a href="#" class="p-3"><span class="icon-facebook"></span></a>
        <a href="#" class="p-3"><span class="icon-twitter"></span></a>
        <a href="#" class="p-3"><span class="icon-instagram"></span></a>
        <a href="#" class="p-3"><span class="icon-linkedin"></span></a>
        <a href="#" class="p-3"><span class="icon-pinterest"></span></a>
        </p>
        </div>
        </div> --}}
        <div class="row">
        <div class="col-md-12">
        <p class="mb-0">

        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Green Purse Limited

        </p>
        </div>
        </div>
        </div>
        </div>
        </div>
        <script src="{{asset('front/js/jquery-3.3.1.min.js')}}"></script>
        <script src="{{asset('front/js/jquery-ui.js')}}"></script>
        <script src="{{asset('front/js/popper.min.js')}}"></script>
        <script src="{{asset('front/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('front/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('front/js/jquery.countdown.min.js')}}"></script>
        <script src="{{asset('front/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('front/js/jquery.easing.1.3.js')}}"></script>
        <script src="{{asset('front/js/aos.js')}}"></script>
        <script src="{{asset('front/js/jquery.fancybox.min.js')}}"></script>
        <script src="{{asset('front/js/jquery.sticky.js')}}"></script>
        <script src="{{asset('front/js/main.js')}}"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-23581568-13');
        </script>
        <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"8626b46a2d29369a","b":1,"version":"2024.2.4","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
        </body>

        </html>
