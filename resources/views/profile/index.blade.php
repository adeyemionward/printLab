@extends('layout.landing_master')
@section('content')
@section('title', 'Profile')

<div class="hero-area section-bg2">
<div class="container">
<div class="row">
<div class="col-xl-12">
<div class="slider-area">
<div class="slider-height2 slider-bg4 d-flex align-items-center justify-content-center">
<div class="hero-caption hero-caption2">
<h2>Profile</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('profile.index')}}">Profile</a></li>
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

<div class="row">
<div class="col-12">
<h2 class="contact-title">Profile Details</h2>
</div>
<div class="col-lg-8">
    <form class="form-contact contact_form" id="profile_update"  method="POST">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="firstname" id="firstname" required type="text" value="{{Auth::user()->firstname}}" placeholder="Enter your firstname">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="lastname" id="lastname" required type="text" value="{{Auth::user()->lastname}}"  placeholder="Enter your lastname">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="phone" id="phone" required type="text" value="{{Auth::user()->phone}}"  placeholder="Enter your phone number">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="email" id="email" required type="email" value="{{Auth::user()->email}}" placeholder="Email">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input class="form-control" name="company_name" required id="company_name" type="text" value="{{Auth::user()->company_name}}"  placeholder="Enter Schoolname">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <textarea class="form-control w-100" name="address" required id="address" cols="6" rows="3"  placeholder=" Enter Address">{{Auth::user()->address}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <button type="submit" id="subBtn1" class="button button-contactForm boxed-btn">Send</button>
        </div>
    </form>
</div>

</div>
</div>
</section>

</main>
@endsection

<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

      $("#profile_update1").submit(function(e){
        e.preventDefault();
        //alert();

        var all = $(this).serialize();
        //console.log(all);
        $.ajax({
            url:  "",
            type: "POST",
            data: all,


            beforeSend:function(){
               // $(document).find('span.error-text').text('');
                $('#loginBtn').prop('disabled',true);
                $('#loginBtn').css('cursor', 'not-allowed');
                $('#loginBtn').html('<span class="flex justify-center items-center">Authenticating... </span>');
            },

            success: function(data){

                if (data.status==0) {
                    $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                   // $('#save').prop('disabled', false);
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');
                }
                if(data == 1){
                    toastr.success("Registration Successful");
                    setInterval(function(){
                        window.location.replace('{{route("track_orders.index")}}');
                    },2000)

                }else if (data == 12){
                    toastr.success("Registration Successful");
                    setInterval(function(){ //customer dashboard login
                        window.location.href = document.referrer;
                    },2000)

                }else if(data == 5){
                    toastr.error("Error occured: Please try later");
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');

                }else if(data == 7){
                    toastr.error("Error occured: Incorrect Email/Password");
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');

                }
            }
        })
    });
</script>
