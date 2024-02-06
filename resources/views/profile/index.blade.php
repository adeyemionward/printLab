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
                    <input class="form-control" name="company_name" required id="company_name" type="text" value="{{Auth::user()->company_name}}"  placeholder="Enter school/company name">
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



<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

      $("#profile_update").submit(function(e){
        e.preventDefault();

        var all = $(this).serialize();
        //console.log(all);
        $.ajax({
            url:  "",
            type: "POST",
            data: all,


            beforeSend:function(){
               // $(document).find('span.error-text').text('');
                $('#subBtn1').prop('disabled',true);
                $('#subBtn1').css('cursor', 'not-allowed');
                $('#subBtn1').html('<span class="flex justify-center items-center">Processing... </span>');
            },

            success: function(data){

                if (data.status==0) {
                    $.each(data.error, function(prefix, val){
                        toastr.error("Error occured: Please try later").text(val[0]);
                    });
                   // $('#save').prop('disabled', false);
                    $("#subBtn1").attr('disabled',false);
                    $('#subBtn1').css('cursor', 'pointer');
                    $('#subBtn1').html('<span class="flex justify-center items-center">Send </span>');
                }
                if(data == 1){
                    toastr.success("Profile updated successfully");
                    setInterval(function(){
                        window.location.replace('{{route("contact.index")}}');
                    },2000)

                }else if(data == 5){
                    toastr.error("Error occured: Please try later");
                    $("#subBtn1").attr('disabled',false);
                    $('#subBtn1').css('cursor', 'pointer');
                    $('#subBtn1').html('<span class="flex justify-center items-center">Send </span>');

                }else if(data == 2){
                    toastr.error("Error occured: Please try later");
                    $("#subBtn1").attr('disabled',false);
                    $('#subBtn1').css('cursor', 'pointer');
                    $('#subBtn1').html('<span class="flex justify-center items-center">Send </span>');

                }
            }
        })
    });
</script>
@endsection

