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
<h2>Change Password</h2>
<nav aria-label="breadcrumb">
<ol class="breadcrumb justify-content-center">
<li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route('profile.change_password')}}">Password</a></li>
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
<h2 class="contact-title">Change Password</h2>
</div>
<div class="col-lg-8">
    <form class="form-contact contact_form" id="profile_password"  method="POST">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="old_password" id="old_password" required type="password"  placeholder="Enter old password">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="password" id="password" required type="password"  placeholder="Enter new password ">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control valid" name="password_confirmation" id="password_confirmation" required type="password"  placeholder="Confirm  password">
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <button type="submit" id="sendBtn" class="button button-contactForm boxed-btn">Send</button>
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

      $("#profile_password").submit(function(e){
        e.preventDefault();

        var all = $(this).serialize();
        //console.log(all);
        $.ajax({
            url:  "",
            type: "POST",
            data: all,


            beforeSend:function(){
               // $(document).find('span.error-text').text('');
                $('#sendBtn').prop('disabled',true);
                $('#sendBtn').css('cursor', 'not-allowed');
                $('#sendBtn').html('<span class="flex justify-center items-center">Processing... </span>');
            },

            success: function(data){

                if (data.status==0) {
                    $.each(data.error, function(prefix, val){
                        // $('span.'+prefix+'_error').text(val[0]);
                        toastr.error("Error occured: Please try later").text(val[0]);
                    });
                   // $('#save').prop('disabled', false);
                    $("#sendBtn").attr('disabled',false);
                    $('#sendBtn').css('cursor', 'pointer');
                    $('#sendBtn').html('<span class="flex justify-center items-center">Send </span>');
                }
                if(data == 1){
                    toastr.success("Password Changed Successfully");
                    setInterval(function(){
                        window.location.replace('{{route("profile.index")}}');
                    },2000)

                }else if(data == 5){
                    toastr.error("Error occured: Please try later");
                    $("#sendBtn").attr('disabled',false);
                    $('#sendBtn').css('cursor', 'pointer');
                    $('#sendBtn').html('<span class="flex justify-center items-center">Send </span>');

                }else if(data == 2){
                    toastr.error("Error occured: Incorrect Password Entered");
                    $("#sendBtn").attr('disabled',false);
                    $('#sendBtn').css('cursor', 'pointer');
                    $('#sendBtn').html('<span class="flex justify-center items-center">Send </span>');

                }
            }
        })
    });
</script>
@endsection


